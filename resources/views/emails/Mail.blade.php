<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail</title>
</head>

<body>
    <p> Благодарим вас за регистрацию на сборы ТСК «Московия»</p>
    <p> Ниже представлена итоговая информация по вашей заявке.</p>
    <h2> Участники сборов: </h2>
    <ul>
        @foreach ($details['main'] as $member)
        @if ($member['name'])
        <li> {{ $member['name'] }} / {{ $member['birthdate'] }} / {{ $details['club']['name'] }}, г. {{ $details['club']['city'] }}</li>
        @endif
        @endforeach
    </ul>

    <h2>Даты участия в сборах: </h2>
    <p>
        @foreach ($details['dates'] as $date)
        {{ $date . ', ' }}
        @endforeach
    </p>

    <h2>Запланированные уроки:</h2>
    <ul>
        @foreach ($details['coaches'] as $coach)
        <li>{{ $coach['name'] }} - {{ $coach['taked_hours'] }} ур. (Стоимость урока 45мин. - {{$coach['price']}} {{ $coach['currency']}})</li>
        @endforeach
    </ul>
    

    <h2>Дополнительная информация по звяке:</h2>
    <ul>
        <li>
            Тариф сборов: @if ($details['tax']) {{ $details['tax'] }} @endif
        </li>
        <li>
            Проживание на время сборов: @if ($details['hotel']['status'])
            <ul>
                <li>
                    Нужно, номер для связи: {{ $details['hotel']['phone'] }}
                    @else Не нужно @endif
                </li>
            </ul>
        </li>
        <li>
            Сопровождающие лица:
            @if ($details['companions'])
            <ul>
                @foreach ($details['companions_info'] as $companion)
                @if ($companion['name'] && $companion['birthdate']) {
                <li>{{ $companion['name'] }}, {{ $companion['birthdate'] }}</li>
                }
                @endif
                @endforeach
            </ul>
            @endif
        </li>
        <li>
            Комментарий к заявке:
            <p>{{ $details['comments']}}</p>
        </li>
        <li>
            К оплате за сборы:
            <p>
             За сборы - {{ $details['camp_cost']['camp_price']}}, За индивидуальные уроки - {{ $details['camp_cost']['coaches_price']['rub'] }}руб. + {{$details['camp_cost']['coaches_price']['euro']}} euro
            </p>
        </li>
    </ul>
    <h5>Напоминаем, что оплату за участие в сборах необходимо внести в первый день!</h5>
    <p>
        Если в данной заявке присутствует неточность, пожалуйста, сообщите об этом, в ответном письме, обязательно указав соответствующий заголовок письма!
    </p>

</body>

</html>