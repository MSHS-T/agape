<u>{{ str_plural(__('fields.projectcall.application')) }} :</u>
<span>
    @date(['date' => $projectcall->application_start_date])&nbsp;&rarr;&nbsp;@date(['date' => $projectcall->application_end_date])
</span>
<br />
<u>{{ str_plural(__('fields.projectcall.evaluation')) }} :</u>
<span>
    @date(['date' => $projectcall->evaluation_start_date])&nbsp;&rarr;&nbsp;@date(['date' => $projectcall->evaluation_end_date])
</span>