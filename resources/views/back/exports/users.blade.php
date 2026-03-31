@php
    $filters = $request->filters;
@endphp

<table>
    <thead>
        <tr>
            @isset($filters['id'])
                <th>آیدی</th>
            @endisset

            @isset($filters['first_name'])
                <th>نام</th>
            @endisset

            @isset($filters['last_name'])
                <th>نام خانوادگی</th>
            @endisset

            @isset($filters['username'])
                <th>نام کاربری</th>
            @endisset

            @isset($filters['email'])
                <th>ایمیل</th>
            @endisset

            @isset($filters['created_at'])
                <th>تاریخ ثبت نام</th>
            @endisset

            @isset($filters['birthday'])
                <th>تاریخ تولد</th>
            @endisset

        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                @isset($filters['id'])
                    <td>{{ $user->id }}</td>
                @endisset

                @isset($filters['first_name'])
                    <td>{{ $user->first_name }}</td>
                @endisset

                @isset($filters['last_name'])
                    <td>{{ $user->last_name }}</td>
                @endisset

                @isset($filters['username'])
                    <td>{{ $user->username }}</td>
                @endisset

                @isset($filters['email'])
                    <td>{{ $user->email }}</td>
                @endisset

                @isset($filters['created_at'])
                    <td>{{ jdate($user->created_at) }}</td>
                @endisset

                @isset($filters['birthday'])
                    <td>{{ $user->birthday ? jdate($user->birthday)->format('Y/m/d') : '' }}</td>
                @endisset
            </tr>
        @endforeach
    </tbody>
</table>
