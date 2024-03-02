<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Transaction Report All</title>
    <style>
        .bangla,
        .bangla td {
            font-family: SolaimanLipi;
        }

        .txt-eng {
            font-family: Helvetica;
            font-size: 12px;
        }

        .tbl-border {
            border: 1px solid #000;
        }

        .page-header {
            font-size: 18px;
            font-weight: bold;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            flex-wrap: nowrap;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        tfoot {
            font-weight: bold;
        }

        .border-bottom {
            border-bottom: 1px dotted #000;
            width: 100%;
            margin-top: 20px;
        }

        .signature-container {
            margin-top: 75px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 20%;
            float: left;
            text-align: center;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .signature-box span {
            border-bottom: 1px solid #000;
            display: inline-block;
            width: 80%;
        }
    </style>
</head>

<body>
    <div style="margin-top: 10px; margin-bottom: 10px; text-align: center;">
        <h2 class="bangla page-header" style="font-weight: bold; font-size: 28px; margin-bottom: -3.4;">
            Metro Homes Limited
        </h2>
        <br>
        <h3 class="bangla page-header" style="font-size: 15px; font-weight: bold; margin: 0;">
            Metro Shopping Mall, (4th floor), House #1, Road #12/A (New), Mirpur Road, Dhanmondi Dhaka
        </h3>

        <p class="bangla page-header" style="font-size: 18px; font-weight: bold; border-top: 1px solid #000; padding-top: 10px;">
            {{ $customer->name }}<br> @foreach($customer->flats as $flat)
            {{ $flat->flat_number }}
            @endforeach
        </p>
    </div>
    <div class="flex-container">
        <div style="text-align: right;">
            Date Range:
            @if(count($customerVouchers) > 0)
                {{ reset($customerVouchers)['month'] }} - {{ end($customerVouchers)['month'] }}
            @endif
        </div>
    </div>



    <table class="details-table" style="font-size: 12px; width: 50%;">
    <tr>
        <td class="label">Phone:</td>
        <td class="value">{{ $customer->phone }}</td>
    </tr>
    <tr>
        <td class="label">Email:</td>
        <td class="value">{{ $customer->email }}</td>
    </tr>
    <tr>
        <td class="label">Details:</td>
        <td class="value">{{ $customer->details }}</td>
    </tr>
    <tr>
        <td class="label">Total Installment:</td>
        <td class="value">{{ $customer->total_installment }}</td>
    </tr>
    <tr>
        <td class="label">Installment:</td>
        <td class="value" style="font-size: 11px;">{{ $customer->installment }}</td>
    </tr>
    <tr>
        <td class="label">Car Park:</td>
        <td class="value">{{ $customer->garage }}</td>
    </tr>
</table>





    <div>
        @if(count($customerVouchers) > 0)
        <table class="txt-eng tbl-border">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Installment Amount</th>
                    <th>Refund Money</th>
                    <th>Delay Charge</th>
                    <th>Utility Charge</th>
                    <th>Tiles Work</th>
                    <th>Special Discount</th>
                    <th>Garage Money</th>
                    <th>Miscellaneous Cost</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalInstallment = 0;
                $totalrefundmoney = 0;
                $totalDelayCharge = 0;
                $totalUtilityCharge = 0;
                $totaltileswork = 0;
                $totalSpecialDiscount = 0;
                $totalGarageMoney = 0;
                $totalmiscellaneouscost = 0;
                @endphp
                @foreach ($customerVouchers as $voucher)
                <tr>
                    <td>{{ $voucher['month'] }}</td>
                    <td>{{ $voucher['description'] }}</td>
                    <td>{{ $voucher['amount'] }}</td>
                    <td>{{ $voucher['refund_money'] }}</td>
                    <td>{{ $voucher['delay_charge'] }}</td>
                    <td>{{ $voucher['utility_charge'] }}</td>
                    <td>{{ $voucher['tiles_work'] }}</td>
                    <td>{{ $voucher['special_discount'] }}</td>
                    <td>{{ $voucher['car_money'] }}</td>
                    <td>{{ $voucher['miscellaneous_cost'] }}</td>
                     <td>
                        @php
                        $totalInstallment += $voucher['amount'];
                        $totalrefundmoney += $voucher['refund_money'];

                        $totalDelayCharge += $voucher['delay_charge'];
                        $totalUtilityCharge += $voucher['utility_charge'];
                        $totaltileswork += $voucher['tiles_work'];

                        $totalSpecialDiscount += $voucher['special_discount'];
                        $totalGarageMoney += $voucher['car_money'];
                        $totalmiscellaneouscost += $voucher['miscellaneous_cost'];

                        @endphp

                        {{ $voucher['amount'] + $voucher['delay_charge'] + $voucher['utility_charge'] - $voucher['special_discount'] + $voucher['car_money'] + $voucher['tiles_work'] + $voucher['miscellaneous_cost'] -$voucher['refund_money'] }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td>Total:</td>
                    <td></td>
                    <td>{{ $totalInstallment }}</td>
                    <td>{{ $totalrefundmoney }}</td>

                    <td>{{ $totalDelayCharge }}</td>
                    <td>{{ $totalUtilityCharge }}</td>
                    <td>{{ $totaltileswork }}</td>

                    <td>{{ $totalSpecialDiscount }}</td>
                    <td>{{ $totalGarageMoney }}</td>
                    <td>{{ $totalmiscellaneouscost }}</td>

                    <td>
                        @php
                        $totalAmount = $totalInstallment + $totalDelayCharge + $totalUtilityCharge - $totalSpecialDiscount + $totalGarageMoney - $totalrefundmoney + $totaltileswork + $totalmiscellaneouscost;
                        echo $totalAmount;
                        @endphp
                    </td>
                </tr>
            </tfoot>
        </table>

        @else
        <p>No vouchers available</p>
        @endif
    </div>



    <div class="border-bottom">
        <p class="bangla" style="font-size: 12px; margin-top: 2px;">
            In Taka: টাকা
        </p>
    </div>
</body>

</html>
