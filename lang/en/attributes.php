<?php

return [
    // Project Call
    'project_call_type'      => 'Project Call Type',
    'year'                   => 'Year',
    'application_start_date' => 'Application Start Date',
    'application_end_date'   => 'Application End Date',
    'evaluation_start_date'  => 'Evaluation Start Date',
    'evaluation_end_date'    => 'Evaluation End Date',
    'privacy_clause'         => 'Privacy Clause',
    'invite_email'           => 'Invite Email',
    'help_experts'           => 'Online Expert Help',
    'help_candidates'        => 'Online Candidate Help',
    'notation'               => 'Evaluation Guide',
    'number_of_documents'    => 'Maximum Number of Files in "Other Attachments" Field',
    'number_of_laboratories' => 'Maximum Number of Laboratories',
    'number_of_study_fields' => 'Maximum Number of Study Fields',
    'number_of_keywords'     => 'Maximum Number of Keywords',
    'accepted_extensions'    => 'Accepted Extensions: :extensions',
    'files'                  => [
        'applicationForm'        => 'Application Form',
        'financialForm'          => 'Financial Form',
        'additionalInformation'  => 'Additional Information',
        'otherAttachments'       => 'Other Attachments',
    ],
    'project_call_status' => [
        'planned'                => 'Planned',
        'application'            => 'Application',
        'waiting_for_evaluation' => 'Waiting for Evaluation',
        'evaluation'             => 'Evaluation',
        'waiting_for_decision'   => 'Waiting for Decision',
        'finished'               => 'Finished',
        'archived'               => 'Archived',
    ],

    // Application
    'acronym'                  => 'Acronym',
    'short_description'        => 'Short Description',
    'summary_fr'               => 'Public Summary (FR)',
    'summary_en'               => 'Public Summary (EN)',
    'carrier'                  => 'Project Carrier',
    'carrier_status'           => 'Status',
    'contact_name'             => 'Contact Name',
    'main_laboratory'          => 'Main Laboratory',
    'other_laboratories'       => 'Other Laboratories and Partners',
    'keywords'                 => 'Keywords',
    'amount_requested'         => 'Amount Requested to MSHS-T',
    'other_fundings'           => 'Total of Co-Fundings',
    'total_expected_income'    => 'Total Expected Income',
    'total_expected_outcome'   => 'Total Expected Outcome',
    'submitted_at'             => 'Submission Date',
    'devalidation_message'     => 'Devalidation Message',
    'selection_comity_opinion' => 'Selection Comity Opinion',

    // Project Call Type
    'label_long'         => 'Long Label',
    'label_short'        => 'Short Label',
    'dynamic_attributes' => [
        'title'       => 'Dynamic Properties',
        'label'       => 'Field Label (Translated)',
        'location'    => 'Location',
        'section'     => 'Section',
        'after_field' => 'After Field',
        'type'        => 'Field Type',
        'types'       => [
            'text'     => 'Short Text',
            'date'     => 'Date',
            'richtext' => 'Text Area with Formatting',
            'textarea' => 'Text Area',
            'checkbox' => 'Checkboxes',
            'select'   => 'Dropdown',
        ],
        'options'            => 'Options',
        'option_label'       => 'Option (Translated)',
        'option_multiple'    => 'Multiple Choices?',
        'choices'            => 'Choices',
        'choice_label'       => 'Choice (Translated)',
        'choice_description' => 'Description (Translated)',
        'rules'              => 'Validation Rules',
        'required'           => 'Required Field?',
        'min_value'          => 'Minimum Value',
        'max_value'          => 'Maximum Value',
        'repeatable_field'   => 'Repeatable Field',
        'repeatable'         => 'Multiple Values?',
        'min_items'          => 'Minimum Number of Items',
        'max_items'          => 'Maximum Number of Items',
    ],

    // Laboratory
    'unit_code'      => 'Unit Code',
    'director_email' => 'Director Email',
    'regency'        => 'Laboratory Regency (CNRS, University or Other)',

    // User
    'first_name'            => 'First Name',
    'last_name'             => 'Last Name',
    'email'                 => 'Email Address',
    'phone'                 => 'Phone',
    'role'                  => 'Role',
    'email_verified'        => 'Email Verified?',
    'last_active_at'        => 'Last Active',
    'managed_types'         => 'Managed Call Types',
    'password'              => 'Password',
    'password_confirmation' => 'Confirm Password',

    // Generic
    'name'        => 'Name',
    'title'       => 'Title',
    'description' => 'Description',
    'status'      => 'Status',
    'reference'   => 'Reference',
    'owner'       => 'Owner',
    'creator'     => 'Creator',
    'created_at'  => 'Created At',
    'updated_at'  => 'Updated At',
];
