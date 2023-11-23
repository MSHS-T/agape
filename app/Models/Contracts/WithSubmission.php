<?php

namespace App\Models\Contracts;

interface WithSubmission
{
    public function submit(bool $force = false): static;
    public function unsubmit(string $message): static;

    public function getSubmissionNotification(string $name): ?string;
    public function resolveAdmins(): \Illuminate\Support\Collection|array;
}
