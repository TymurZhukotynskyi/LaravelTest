<!DOCTYPE html>
<html>
<head>
    <title>Page A</title>
</head>
<body>
<h1>Page A</h1>
<p>Current link: {{ $link->unique_link }}</p>

<form method="POST" action="{{ route('LuckyNumber.generate_new_link', $link->unique_link) }}">
    @csrf
    <button name="action" value="new_link">Generate New Link</button>
</form>

@if (isset($isNewLink) && $isNewLink)
    <p>That's your new Link: {{$link->getFullLinkToGamePage()}}</p>
    <p><b>The current page is unavailable for further activity</b></p>
@endif

<form method="POST" action="{{ route('LuckyNumber.deactivate_link', $link->unique_link) }}">
    @csrf
    <button name="action" value="deactivate">Deactivate Link</button>
</form>

@if (isset($linkDeactivated) && $linkDeactivated)
    <p><b>The current page is unavailable for further activity</b></p>
    <p>Go to <a href="/">Register</a> for get new link!</p>
@endif

<form method="POST" action="{{ route('LuckyNumber.play', $link->unique_link) }}">
    @csrf
    <button name="action" value="im_feeling_lucky">I'm Feeling Lucky</button>
</form>

@if (isset($result))
    <h2>Last Result</h2>

    Your Lucky Number: {{$result->result_number}}; <br>
    That's mean: {{$result->result}}; <br>
    So your win amount: {{$result->win_amount}}; <br>
@endif

<form method="POST" action="{{ route('LuckyNumber.show_history', $link->unique_link) }}">
    @csrf
    <button name="action" value="history">Show History</button>
</form>

@if (isset($historyResults))
    <h2>History (Last 3 Results)</h2>

    <ul>
        @foreach ($historyResults as $result)
            <li>{{ $result->result_number }} - {{ $result->result }} - {{ $result->win_amount }}</li>
        @endforeach
    </ul>
@endif
</body>
</html>
