
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="title">Agreement</title>
    <style>

        h1 {
            text-align: center;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
        }

        .sub-section {
            margin-left: 20px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            text-align: center;
        }

        .table2 {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            margin-top: 40px;
        }

        .table2 td
        {
            padding-bottom: 20px;
        }
        .table th,
        .table td {
            border: 1px solid black;
            padding: 10px;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            font-size: 16px;
            text-decoration: underline;
        }

        h2 {
            font-size: 16px;
            text-decoration: underline;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
        }

        .sub-section {
            margin-left: 20px;
        }

        p {
            font-size: 14px;
            margin: 0;
        }

        .image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .footer {
            color: green;
            text-align: center;
            padding: 10px;
            width: 100%;
            position: fixed;
            bottom: 0;
        }

        .footer a {
            color: #fff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        img {
            max-width: 34%;
            height: auto;
        }

        .second-image {
            position: relative;
            bottom: 80px;
            order: 1;
            width: 40%;
        }

        .text {
            font-size: 16px;
            position: relative;
            bottom: 130px;
            text-align: center;
            color: darkgreen;
            left: 15px;
        }
    </style>
</head>

<body>
    <div class="image-container">
        <img src="C:\Users\BadShah\Desktop\tennis_court\public\aglie_courts_logo.jpg" />
        <img src="C:\Users\BadShah\Desktop\tennis_court\public\text_logo.jpg" class="second-image" />
        <h3 class="text">CONSTRUCTION CO. <br>CELEBRATING OUR 50TH YEAR 1972-2022 <br>"QUALITY STILL EXISTS"</h3>
    </div>
    <h1>AGREEMENT</h1>
    <div class="section">
        <table class="table">
            <thead>
                <tr>
                    <th>WORK TO BE PERFORMED</th>
                    <th>CUSTOMER</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data['work_to_be_performed'] }}</td>
                    <td>{{ $data['customer'] }}</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    <div class="section">
        <p>Agreement made between Agile Courts Construction Company, Inc. hereinafter called the Contractor</p>
        <p>and test hereinafter called the Customer for the construction of (2) tennis courts and refurbishment of</p>
        <p>(3) tennis courts of test with respect to the following terms and specifications</p>
    </div>

    <div class="section">
        <h2>{{$data['overseas_conditions_heading']}}</h2>
        @foreach ($data['overseas_conditions'] as $key => $item)
        @if ($item['input'] === true)
        <p>{{ $item['title'] }}: {{ $item['input_value'] }}</p>
        @endif
        @endforeach
    </div>

    <div class="section">
        <h2>{{$data['base_heading']}}</h2>
        @foreach ($data['base'] as $key => $item)
        @if ($item['input'] === true)
        <p>{{ $item['title'] }}: {{ $item['input_value'] }}</p>
        @endif
        @endforeach
    </div>

    <div class="section">
        <h2>{{$data['fence_heading']}}</h2>
        @foreach ($data['fence'] as $key => $item)
        @if ($item['input'] === true)
        <p>{{ $item['title'] }}: {{ $item['input_value'] }}</p>
        @endif
        @endforeach
    </div>

    <div class="section">
        <h2>{{$data['lights_heading']}}</h2>
        @foreach ($data['lights'] as $key => $item)
        @if ($item['input'] === true)
        <p>{{ $item['title'] }}: {{ $item['input_value'] }}</p>
        @endif
        @endforeach
    </div>

    <div class="section">
        <h2>{{$data['provisions_heading']}}</h2>
        @foreach ($data['provisions'] as $key => $item)
        @if ($item['input'] === true)
        <p>{{ $item['title'] }}: {{ $item['input_value'] }}</p>
        @endif
        @endforeach
    </div>
    <div class="section">
        <h2>{{$data['conditions_heading']}}</h2>
        @foreach ($data['conditions'] as $key => $item)
        @if ($item['input'] === true)
        <p>{{ $item['title'] }}: {{ $item['input_value'] }}</p>
        @endif
        @endforeach
    </div>
    <div class="table2">
        <table>
            <thead>
                <tr>
                    <th>Accepted by</th>
                    <th>Agile Courts Construction Company</th>
                </tr>
                <br>
            </thead>
            <tbody>
                <tr >
                

                    <td >_________________________________</td>

                    <td ><img src="{{ $data['signature'] }}" alt="Signature"></td>
                </tr>
                <tr> 
                    <td>Date______________________________</td>
                    <td>Name</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
    <div class="footer">
        <p>PHONE: (305) 667-1228 | EMAIL: INFO@AGILECOURTS.NET</p>
    </div>
</body>

</html>