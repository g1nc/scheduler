@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col s12">
            @include('layout.filter')
            <table class="highlight">
                <thead>
                    <tr>
                        <th data-field="region">Регион</th>
                        <th data-field="courier">Курьер</th>
                        <th data-field="way">Длительность</th>
                        <th data-field="exit">Дата выезда</th>
                        <th data-field="arrival">Дата прибытия</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($trips as $trip)
                    <tr>
                        <td>{{ $trip->region->name }}</td>
                        <td>{{ $trip->courier->name }}</td>
                        <td>{{ $trip->region->long }}</td>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $trip->start)->format('d.m.Y') }}</td>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $trip->end)->format('d.m.Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection