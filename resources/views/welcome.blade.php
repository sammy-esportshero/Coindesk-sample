<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <title>Portfolio Tracker</title>

        <!-- Styles -->
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            tr:hover {
                background-color:#f5f5f5
            }
        </style>
    </head>

    <body>
        <!--Portfolio-->
        <table>
            <tr>
                <td>Currency</td>
                <td>Balance</td>
            </tr>

            <tr>
                <td>Bitcoin (BTC)</td>
                <td><input type="text" id="btc"></td>
            </tr>

            <tr>
                <td>Ethereum (ETH)</td>
                <td><input type="text" id="eth"></td>
            </tr>

            <tr>
                <td>Litecoin (LTC)</td>
                <td><input type="text" id="ltc"></td>
            </tr>

            <tr>
                <td>Ripple (XRP)</td>
                <td><input type="text" id="xrp"></td>
            </tr>

            <tr>
                <td>NEM (XEM)</td>
                <td><input type="text" id="xem"></td>
            </tr>

            <tr>
                <td>Dash </td>
                <td><input type="text" id="dash"></td>
            </tr>

            <tr>
                <td>Iota (MIOTA)</td>
                <td><input type="text" id="miota"></td>
            </tr>

            <tr>
                <td>Stratis (STRAT)</td>
                <td><input type="text" id="strat"></td>
            </tr>

            <tr>
                <td>EOS</td>
                <td><input type="text" id="eos"></td>
            </tr>

            <tr>
                <td>Steem</td>
                <td><input type="text" id="steem"></td>
            </tr>

        </table>

        <br/>

        <input id="getROI" type="submit" style="width:25%" value="24hour ROI">

        <!--Portfolio Return-->
        <br/>
        <br/>

        <div id="percentDifference"></div>

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#getROI").click(function(e) {
                e.preventDefault();

                //AJAX call for % diff of front(portfolio) - history(portfolio)
                $.ajax({
                    type: "POST",
                    url: "/api/portfolioROI",
                    data: {
                        "BTC" : $("#btc").val(),
                        "ETH" : $("#eth").val(),
                        "LTC" : $("#ltc").val(),
                        "XRP" : $("#xrp").val(),
                        "XEM" : $("#xem").val(),
                        "DASH" : $("#dash").val(),
                        "MIOTA" : $("#miota").val(),
                        "STRAT" : $("#strat").val(),
                        "EOS" : $("#eos").val(),
                        "STEEM" : $("#steem").val()
                    },
                    success: function(data,status) {
                        //Populate Portfolio Return div

                        //Probably have to watch for floating point error
                        //Not a big enough deal to fret about right now
                        $("#percentDifference").text((Math.round(data * 100) / 100)+"%");
                        if(data > 0) {
                            $("#percentDifference").css('color','green');
                        } else {
                            $("#percentDifference").css('color','red');
                        }
                    },
                    error: function(exception) {
                        //alert(exception);
                    },
                    dataType: 'json',
                    encode: true
                });
            });
        </script>
    </body>
</html>
