<!DOCTYPE html>
<html>
<head>
    <title>Battle History</title>
    <style>
        body { font-family: Arial, sans-serif; background: #1a1a1a; color: #fff; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 10px; text-align: center; }
        th { background: #333; }
        .btn { display: inline-block; padding: 10px 20px; background: #e74c3c; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
<h2>Battle History</h2>
<a href="{{ route('battle.start') }}" class="btn">Start New Battle</a>

<table>
    <tr>
        <th>ID</th>
        <th>Hero</th>
        <th>Monster</th>
        <th>Winner</th>
        <th>Rounds</th>
    </tr>
    @foreach($battles as $b)
        <tr>
            <td>{{ $b->getId() }}</td>
            <td>{{ $b->getHeroName() }}</td>
            <td>{{ $b->getMonsterName() }}</td>
            <td>{{ $b->getWinnerName() }}</td>
            <td>{{ $b->getRoundsTotal() }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
