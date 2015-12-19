@extends('layout.app')

@section('content')
    <div class="row valign-wrapper">
        <form action="{{ URL::to('create') }}" class="valign col s8" method="post">
            <input type="text" name="_token" value="{{ csrf_token() }}" hidden>
            <div class="input-field col s6">
                <select name="courier_id" id="courier">
                @foreach($couriers as $courier)
                    <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                @endforeach
                </select>
                <label for="courier">Курьер</label>
            </div>
            <div class="input-field col s6">
                <select name="region_id" id="region">
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" data-long="{{ $region->long }}">{{ $region->name }}</option>
                    @endforeach
                </select>
                <label for="region">Регион</label>
            </div>
            <div class="input-field col s6">
                <input type="date" id="start" name="start" class="datepicker">
                <label for="start">Выезд</label>
            </div>
            <div class="input-field col s6">
                <input type="date" id="end" name="end" class="datepicker" disabled>
                <label for="end">Прибытие</label>
            </div>
            <div class="input-field col s12 center">
                <button id="create-submit" class="waves-effect waves-light orange btn"><i class="fa fa-send right"></i>Отправить</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(function(){
            // Перерасчет даты прибытия при изменении даты выезда или региона
            $('#start').on('change', function(){
                calculateEndDate();
            });
            $('#region').on('change', function(){
                calculateEndDate();
            });

            // Первичная валидация
            $('#create-submit').on('click', function(e){
                e.preventDefault();
                if ($('#start').val().length == 0) {
                    Materialize.toast('Необходимо выбрать дату выезда');
                    $('#start').addClass('invalid');
                }
                else {
                    var courier = $('#courier').val();
                    var region = $('#region').val();
                    var start = $('#start').val();

                    $.ajax({
                        method: 'POST',
                        url: '{{ URL::to('create') }}',
                        data: {
                            courier_id: courier,
                            region_id: region,
                            start: start
                        }
                    })
                    .done(function(msg) {
                        Materialize.toast(msg, 4000);
                    });
                }
            });

            function calculateEndDate() {
                var value = $('#start').val();
                if (value.length > 0) {
                    $('#start').removeClass('invalid');
                    value = value.split('.');
                    var long = $('#region option:selected').attr('data-long');
                    var date = new Date(value[2], value[1] - 1, value[0]);
                    date.setTime(date.getTime() +  (long * 24 * 60 * 60 * 1000));
                    var endDate = date.getDate() + '.' + (date.getMonth() + 1) + '.' + (date.getYear() + 1900);
                    $('#end').val(endDate);
                    $('label[for=end]').addClass('active');
                }
                else {
                    $('#end').val('');
                    $('label[for=end]').removeClass('active');
                }
            }
        })
    </script>
@endsection