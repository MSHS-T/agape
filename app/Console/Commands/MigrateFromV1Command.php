<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Models\Evaluation;
use App\Models\EvaluationOffer;
use App\Models\Laboratory;
use App\Models\ProjectCall;
use App\Models\ProjectCallType;
use App\Models\StudyField;
use App\Models\User;
use App\Settings\GeneralSettings;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelReader;

class MigrateFromV1Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-from-v1-command {directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected array $modelMatch = [];
    protected array $userRoleType = [];
    protected array $notationScale = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = $this->checkDirectory(base_path($this->argument('directory')));
        if ($files === null) {
            return;
        }

        // Seed
        $this->call('db:seed', ['--class' => 'ProjectCallTypeSeeder']);

        // Import users
        $this->modelMatch['user'] = [];
        $this->info("Importing users...");
        $this->withProgressBar(
            $this->getRows($files['files']['users']),
            function (array $row) {
                $newUser = User::create([
                    'first_name'        => $row['first_name'] ?? '',
                    'last_name'         => $row['last_name'],
                    'email'             => $row['email'],
                    'password'          => $row['password'],
                    'email_verified_at' => $row['email_verified_at'],
                    'phone'             => $row['phone'],
                ]);
                $this->setTimestamps($newUser, $row);
                $this->modelMatch['user'][$row['id']] = $newUser->id;
                $role = match (intval($row['role'])) {
                    0 => 'applicant',
                    1 => 'expert',
                    2 => 'administrator',
                    3 => 'manager',
                };
                $newUser->assignRole($role);
                if ($role === 'manager') {
                    $this->userRoleType[] = ['user_id' => $newUser->id, 'project_call_type_id' => $row['role_type_id']];
                }
            }
        );
        $this->newLine();

        // Import study fields
        $this->modelMatch['study_field'] = [];
        $this->info("Importing study fields...");
        $this->withProgressBar(
            $this->getRows($files['files']['study_fields']),
            function (array $row) {
                $creatorId = $this->modelMatch['user'][$row['creator_id']];
                $newSf = StudyField::create([
                    'name'       => ['fr' => $row['name'], 'en' => ''],
                    'creator_id' => $creatorId === 1 ? null : $creatorId,
                ]);
                $this->modelMatch['study_field'][$row['id']] = $newSf->id;
            }
        );
        $this->newLine();

        // Import laboratories
        $this->modelMatch['laboratory'] = [];
        $this->info("Importing laboratories...");
        $this->withProgressBar(
            $this->getRows($files['files']['laboratories']),
            function (array $row) {
                if (blank($row['name'])) {
                    return;
                }
                $creatorId = $this->modelMatch['user'][$row['creator_id']];
                $newLab = Laboratory::create([
                    'name'           => $row['name'],
                    'unit_code'      => $row['unit_code'],
                    'director_email' => $row['director_email'] ?? '',
                    'regency'        => $row['regency'],
                    'creator_id'     => $creatorId === 1 ? null : $creatorId,
                ]);
                $this->setTimestamps($newLab, $row);
                $this->modelMatch['laboratory'][$row['id']] = $newLab->id;
            }
        );
        $this->newLine();

        // Import carriers
        $this->modelMatch['carrier'] = [];
        $this->info("Reading carriers...");
        $this->withProgressBar(
            $this->getRows($files['files']['persons']),
            function (array $row) {
                $this->modelMatch['carrier'][$row['id']] = [
                    'first_name' => $row['first_name'],
                    'last_name'  => $row['last_name'],
                    'email'      => $row['email'],
                    'phone'      => $row['phone'],
                    'status'     => $row['status'],
                ];;
            }
        );
        $this->newLine();

        // Matching project call types
        $this->modelMatch['project_call_type'] = [];
        $this->info("Matching project call types...");
        $this->withProgressBar(
            $this->getRows($files['files']['project_call_types']),
            function (array $row) {
                $callType = ProjectCallType::whereReference($row['reference'])->first();
                $this->modelMatch['project_call_type'][$row['id']] = $callType;
            }
        );
        $this->newLine();

        // Applying manager role
        $this->info("Applying manager roles...");
        $this->withProgressBar(
            $this->userRoleType,
            function ($item) {
                $user = User::find($item['user_id']);
                $user->projectCallTypes()->attach(
                    $this->modelMatch['project_call_type'][$item['project_call_type_id']]
                );
            }
        );
        $this->newLine();

        // Import project calls
        $this->modelMatch['project_call'] = [];
        $this->info("Importing project calls...");
        $this->withProgressBar(
            $this->getRows($files['files']['project_calls']),
            function (array $row) use ($files) {
                $creatorId = $this->modelMatch['user'][$row['creator_id']];
                /** @var ProjectCall $newPc */
                $newPc = ProjectCall::create([
                    'project_call_type_id'   => $this->modelMatch['project_call_type'][$row['project_call_type_id']]->id,
                    'creator_id'             => $creatorId,
                    'reference'              => $row['reference'],
                    'year'                   => $row['year'],
                    'title'                  => $row['title'],
                    'description'            => ['fr' => $row['description'], 'en' => ''],
                    'application_start_date' => $row['application_start_date'],
                    'application_end_date'   => $row['application_end_date'],
                    'evaluation_start_date'  => $row['evaluation_start_date'],
                    'evaluation_end_date'    => $row['evaluation_end_date'],
                    'privacy_clause'         => ['fr' => $row['privacy_clause'], 'en' => ''],
                    'invite_email'           => ['fr' => $row['invite_email_fr'], 'en' => $row['invite_email_en']],
                    'help_experts'         => ['fr' => $row['help_experts'], 'en' => ''],
                    'help_candidates'         => ['fr' => $row['help_candidates'], 'en' => ''],
                    'notation' => [
                        [
                            'title'       => ['fr' => $row['notation_1_title'],       'en' => ''],
                            'description' => ['fr' => $row['notation_1_description'], 'en' => '']
                        ],
                        [
                            'title'       => ['fr' => $row['notation_2_title'],       'en' => ''],
                            'description' => ['fr' => $row['notation_2_description'], 'en' => '']
                        ],
                        [
                            'title'       => ['fr' => $row['notation_3_title'],       'en' => ''],
                            'description' => ['fr' => $row['notation_3_description'], 'en' => '']
                        ],
                    ],
                    'extra_attributes' => [
                        'number_of_keywords' => $row['number_of_keywords'],
                        'number_of_documents' => $row['number_of_documents'],
                        'number_of_laboratories' => $row['number_of_laboratories'],
                        'number_of_study_fields' => $row['number_of_study_fields'],
                    ]
                ]);
                $this->setTimestamps($newPc, $row);
                if (filled($applicationForm = $row['application_form_filepath'])) {
                    $filePath = $files['directories']['formulaires'] . DIRECTORY_SEPARATOR . Str::afterLast($applicationForm, '/');
                    $newPc->addMedia($filePath)
                        ->preservingOriginal()
                        ->toMediaCollection('applicationForm');
                }
                if (filled($financialForm = $row['financial_form_filepath'])) {
                    $filePath = $files['directories']['formulaires'] . DIRECTORY_SEPARATOR . Str::afterLast($financialForm, '/');
                    $newPc->addMedia($filePath)
                        ->preservingOriginal()
                        ->toMediaCollection('financialForm');
                }

                $newPc->reference = $row['reference'];
                $newPc->save();

                $this->modelMatch['project_call'][$row['id']] = $newPc->id;
            }
        );
        $this->newLine();

        // Import applications
        $this->modelMatch['application'] = [];
        $this->info("Importing applications...");
        $this->withProgressBar(
            $this->getRows($files['files']['applications']),
            function (array $row) {
                $creatorId = $this->modelMatch['user'][$row['applicant_id']];
                /** @var Application $newApp */
                $newApp = Application::create([
                    'project_call_id'          => $this->modelMatch['project_call'][$row['projectcall_id']],
                    'creator_id'               => $creatorId,
                    'reference'                => $row['reference'],
                    'title'                    => $row['title'],
                    'acronym'                  => $row['acronym'],
                    'carrier'                  => $row['carrier_id'] === null ? null : $this->modelMatch['carrier'][$row['carrier_id']],
                    'short_description'        => $row['short_description'],
                    'summary'                  => ['fr' => $row['summary_fr'], 'en' => $row['summary_en']],
                    'keywords'                 => json_decode($row['keywords']),
                    'other_laboratories'       => $row['other_laboratories'],
                    'amount_requested'         => $row['amount_requested'],
                    'other_fundings'           => $row['other_fundings'],
                    'total_expected_income'    => $row['total_expected_income'],
                    'total_expected_outcome'   => $row['total_expected_outcome'],
                    'selection_comity_opinion' => $row['selection_comity_opinion'],
                    'devalidation_message'     => $row['devalidation_message'],
                ]);
                $this->setTimestamps($newApp, $row);

                $newApp->reference = $row['reference'];

                $dynamicFields = collect($newApp->projectCall->projectCallType->dynamic_attributes)->pluck('slug');
                foreach ($dynamicFields as $field) {
                    $newApp->extra_attributes->set($field, $row[$field]);
                }
                $newApp->save();
                $this->modelMatch['application'][$row['id']] = $newApp->id;
            }
        );
        $this->newLine();

        // Linking applications to laboratories
        $this->info("Linking applications to laboratories...");
        $this->withProgressBar(
            $this->getRows($files['files']['application_laboratory']),
            function (array $row) {
                $applicationId = $this->modelMatch['application'][$row['application_id']];
                /** @var Application $application */
                $application = Application::find($applicationId);
                $laboratoryId = $this->modelMatch['laboratory'][$row['laboratory_id']] ?? null;
                if (blank($laboratoryId)) {
                    return;
                }

                $application->laboratories()->attach(
                    $laboratoryId,
                    [
                        'order'        => $row['order'],
                        'contact_name' => $row['contact_name'],
                    ]
                );
            }
        );
        $this->newLine();

        // Linking applications to study fields
        $this->info("Linking applications to study fields...");
        $this->withProgressBar(
            $this->getRows($files['files']['application_study_field']),
            function (array $row) {
                $applicationId = $this->modelMatch['application'][$row['application_id']];
                /** @var Application $application */
                $application = Application::find($applicationId);
                $studyFieldId = $this->modelMatch['study_field'][$row['study_field_id']];

                $application->studyFields()->attach($studyFieldId);
            }
        );
        $this->newLine();

        // Importing application files
        $this->info("Importing application files...");
        $this->withProgressBar(
            $this->getRows($files['files']['application_files']),
            function (array $row) use ($files) {
                $applicationId = $this->modelMatch['application'][$row['application_id']];
                /** @var Application $application */
                $application = Application::find($applicationId);

                $collectionName = match (intval($row['order'])) {
                    1 => 'applicationForm',
                    2 => 'financialForm',
                    default => 'otherAttachments'
                };

                $filePath = $files['directories']['uploads'] . DIRECTORY_SEPARATOR . Str::afterLast($row['filepath'], '/');
                $media = $application->addMedia($filePath)
                    ->usingFileName($row['name'])
                    ->usingName($row['name'])
                    ->preservingOriginal()
                    ->toMediaCollection($collectionName);
                $this->setTimestamps($media, $row);
            }
        );
        $this->newLine();

        // Import evaluation offers
        $this->modelMatch['evaluation_offer'] = [];
        $this->info("Importing evaluation offers...");
        $this->withProgressBar(
            $this->getRows($files['files']['evaluation_offers']),
            function (array $row) {
                if (blank($row['expert_id'])) {
                    return;
                }
                EvaluationOffer::unsetEventDispatcher();
                $applicationId = $this->modelMatch['application'][$row['application_id']];
                $expertId = $this->modelMatch['user'][$row['expert_id']];
                $accepted = match ($row['accepted']) {
                    "1" => true,
                    "0" => false,
                    default => null
                };
                /** @var EvaluationOffer $newEvalOffer */
                $newEvalOffer = EvaluationOffer::create([
                    'application_id' => $applicationId,
                    'expert_id'      => $expertId,
                    'accepted'       => $accepted,
                    'justification'  => $row['justification'],
                ]);
                $this->setTimestamps($newEvalOffer, $row);

                $retryHistory = json_decode($row['retry_history']);
                if (count($retryHistory) > 0) {
                    $newEvalOffer->extra_attributes->set(
                        'retries',
                        collect($retryHistory)->map(fn($date) => ['at' => $date, 'by' => 1])->toArray()
                    );
                    $newEvalOffer->extra_attributes->set(
                        'retry_count',
                        count($retryHistory)
                    );
                    $newEvalOffer->save();
                }
                $this->modelMatch['evaluation_offer'][$row['id']] = $newEvalOffer->id;
            }
        );
        $this->newLine();

        // Get notation scale
        $this->info("Getting notation scale...");
        /** @var GeneralSettings $generalSettings */
        $generalSettings = app(GeneralSettings::class);
        $this->notationScale = collect($generalSettings->grades)->mapWithKeys(fn($g, $i) => [$i => $g['grade']])->toArray();

        // Import evaluations
        $this->modelMatch['evaluation'] = [];
        $this->info("Importing evaluations...");
        $this->withProgressBar(
            $this->getRows($files['files']['evaluations']),
            function (array $row) {
                if (blank($row['submitted_at'])) {
                    return;
                }
                $evaluationOfferId = $this->modelMatch['evaluation_offer'][$row['offer_id']];
                /** @var EvaluationOffer $evaluationOffer */
                $evaluationOffer = EvaluationOffer::find($evaluationOfferId);

                /** @var Evaluation $evaluationOffer */
                $newEval = Evaluation::create([
                    'evaluation_offer_id' => $evaluationOfferId,
                    'notation'            => $evaluationOffer->application->projectCall->notation,
                    'grades'              => [
                        $this->notationScale[$row['grade1']],
                        $this->notationScale[$row['grade2']],
                        $this->notationScale[$row['grade3']],
                    ],
                    'global_grade'        => $this->notationScale[$row['global_grade']],
                    'comments'            => [
                        $row['comment1'],
                        $row['comment2'],
                        $row['comment3'],
                    ],
                    'global_comment'      => $row['global_comment'],
                    'devalidation_message' => $row['devalidation_message'],
                ]);
                $this->setTimestamps($newEval, $row);

                $this->modelMatch['evaluation'][$row['id']] = $newEval->id;
            }
        );
        $this->newLine();
        $this->info("DONE !");
    }

    protected function getRows(string $file): array
    {
        return SimpleExcelReader::create($file)
            ->getRows()
            ->map(fn($row) => collect($row)->map(fn($value) => $value === "NULL" ? null : $value)->toArray())
            ->all();
    }

    protected function setTimestamps(Model $model, array $row): void
    {
        $model->created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at']);
        $model->updated_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['updated_at'] ?? $row['created_at']);
        if (array_key_exists('submitted_at', $row)) {
            $model->submitted_at = $row['submitted_at'] === null ? null : Carbon::createFromFormat('Y-m-d H:i:s', $row['submitted_at']);
        }
        if (array_key_exists('deleted_at', $row)) {
            $model->deleted_at = $row['deleted_at'] === null ? null : Carbon::createFromFormat('Y-m-d H:i:s', $row['deleted_at']);
        }
        $model->save();
    }

    protected function checkDirectory($directory): ?array
    {
        if (!File::exists($directory) || !File::isDirectory($directory)) {
            $this->error("Invalid directory argument : '$directory'");
            return null;
        }
        $expectedFiles = [
            'users'                   => 'users.csv',
            'application_files'       => 'application_files.csv',
            'application_laboratory'  => 'application_laboratory.csv',
            'application_study_field' => 'application_study_field.csv',
            'applications'            => 'applications.csv',
            'evaluation_offers'       => 'evaluation_offers.csv',
            'evaluations'             => 'evaluations.csv',
            'laboratories'            => 'laboratories.csv',
            'persons'                 => 'persons.csv',
            'project_call_types'      => 'project_call_types.csv',
            'project_calls'           => 'project_calls.csv',
            'study_fields'            => 'study_fields.csv',
        ];

        $expectedDirectories = ['formulaires', 'uploads'];

        foreach ($expectedFiles as $table => $file) {
            if (!File::exists($directory . DIRECTORY_SEPARATOR . $file)) {
                $this->error("Missing file '$file' for table '$table'");
                return null;
            }
        }
        foreach ($expectedDirectories as $dir) {
            if (!File::exists($directory . DIRECTORY_SEPARATOR . $dir) || !File::isDirectory($directory . DIRECTORY_SEPARATOR . $dir)) {
                $this->error("Missing directory '$dir'");
                return null;
            }
        }
        return [
            'files'       => collect($expectedFiles)->map(fn($v) => $directory . DIRECTORY_SEPARATOR . $v)->all(),
            'directories' => collect($expectedDirectories)->mapWithKeys(fn($v) => [$v => $directory . DIRECTORY_SEPARATOR . $v])->all()
        ];
    }
}
