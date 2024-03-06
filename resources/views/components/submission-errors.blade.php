<p class="text-lg font-bold">{{ __('admin.force_submit_error_body') }}</p>
<dl>
    @foreach ($errors as $field => $fieldErrors)
        <dt class="underline font-semibold">{{ $field }} :</dt>
        <dd>
            <ul class="list-disc ml-4">
                @foreach ($fieldErrors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </dd>
    @endforeach
</dl>
