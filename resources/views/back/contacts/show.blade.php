<div class="table-responsive">
    <table class="table">
        <tbody>

            <tr>
                <th scope="row" style="width: 100px;">نام</th>
                <td>{{ $contact->name }}</td>

            </tr>

            <tr>
                <th scope="row">موضوع</th>
                <td>{{ $contact->subject }}</td>
            </tr>
            <tr>
                <th scope="row">ایمیل یا شماره همراه</th>
                <td>{{ $contact->email }}</td>
            </tr>
            {{-- <tr>
                <th scope="row">شماره تلفن</th>
                <td>{{ $contact->mobile }}</td>
            </tr> --}}

            <tr>
                <th scope="row">تاریخ ارسال</th>
                <td>{{ jdate($contact->created_at) }}</td>
            </tr>

            <tr>
                <th scope="row">پیام</th>
                <td>{{ $contact->message }}</td>
            </tr>

        </tbody>
    </table>
</div>
