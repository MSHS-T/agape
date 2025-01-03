<?php

use App\Rules\EmailList;

it('can validate a list of emails', function () {
    $rule = new EmailList();
    $failures = 0;
    $rule->validate('emails', 'john@doe.com,jane@doe.com', function ($fail) use (&$failures) {
        $failures++;
    });

    expect($failures)->toBe(0);
});

it('can validate a list of emails with a custom separator', function () {
    $rule = new EmailList('|');
    $failures = 0;
    $rule->validate('emails', 'john@doe.com|jane@doe.com', function ($fail) use (&$failures) {
        $failures++;
    });

    expect($failures)->toBe(0);
});

it('can ignore empty emails', function () {
    $rule = new EmailList();
    $failures = 0;
    $rule->validate('emails', 'john@doe.com,,jane@doe.com', function ($fail) use (&$failures) {
        $failures++;
    });

    expect($failures)->toBe(0);
});

it('can ignore space before and after the separator', function () {
    $rule = new EmailList();
    $failures = 0;
    $rule->validate('emails', 'john@doe.com, jane@doe.com ,tim@doe.com , jack@doe.com', function ($fail) use (&$failures) {
        $failures++;
    });

    expect($failures)->toBe(0);
});
