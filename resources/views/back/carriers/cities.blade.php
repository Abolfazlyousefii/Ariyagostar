@foreach ($carrier->cities->groupBy('province_id') as $cities)

    <h5>{{ $cities->first()->province->name }}:</h5>

    @foreach ($cities as $city)
        <div class="badge badge-pill  badge-md mb-1">{{ $city->name }}</div>
    @endforeach

    @if (!$loop->last)
        <hr>
    @endif

@endforeach
