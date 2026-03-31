<div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <th scope="row" class="text-nowrap" style="width: 200px;">آیدی</th>
                <td>{{ $sms->id }}</td>
            </tr>

            @if($sms->user)
                <tr>
                    <th scope="row" class="text-nowrap">کاربر پرداخت کننده</th>
                    <td>
                        {{ $sms->user->fullname }} <a class="float-right" href="{{ route('admin.users.show', ['user' => $sms->user]) }}" target="_blank"><i class="feather icon-external-link"></i></a>
                    </td>
                </tr>
            @endif

            <tr>
                <th scope="row" class="text-nowrap">موبایل</th>
                <td>{{ $sms->mobile }}</td>
            </tr>

            <tr>
                <th scope="row" class="text-nowrap">نوع</th>
                <td>{{ $sms->type() }}</td>
            </tr>

            <tr>
                <th scope="row" class="text-nowrap">تاریخ ارسال</th>
                <td>{{ jdate($sms->created_at) }}</td>
            </tr>

            <tr>
                <th scope="row" class="text-nowrap">ip</th>
                <td>{{ $sms->ip }}</td>
            </tr>
            <tr>
                <th scope="row" class="text-nowrap">پنل</th>
                <td>{{ $sms->provider }}</td>
            </tr>

            <tr>
                <th scope="row" class="text-nowrap">پاسخ پنل پیامکی</th>
                <td class="ltr text-right" id="sms-response-message">
                    @php
                        $json_string = json_encode(json_decode($sms->response));
                    @endphp
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    $('#sms-response-message').text(JSON.stringify({!! $json_string !!}, undefined, 4));
</script>
