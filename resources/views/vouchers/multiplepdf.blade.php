<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combined Vouchers</title>
    <style>
        .bangla, .bangla td {
            font-family: SolaimanLipi;
        }
        .txt-eng {
            font-family: Helvetica;
            font-size: 12px;
        }
        .tbl-border {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        .tbl-border th, .tbl-border td {
            border: 1px solid #000;
            padding: 5px;
        }
        .page-header {
            font-size: 18px;
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
        Payment Voucher<br>Cash/Bank
    </p>
</div>

<table class="txt-eng tbl-border">
    <thead>
        <tr>
            <th width="10%" class="bangla">Voucher No</th>
            <th width="15%" class="bangla">Date-Range</th>
            <th width="10%" class="bangla">Check No</th>
            <th width="15%" class="bangla">Paid To</th>
            <th width="30%" class="bangla">Account</th>
            <th width="20%" class="bangla">Taka</th>
        </tr>
    </thead>
          <tbody class="bangla">
          @php
              $totalAmount = 0;
          @endphp

          @forelse($months as $key => $month)
              <tr>
                  <td>{{ $voucherNos[$key] ?? '' }}</td>
                  <td>{{ $month ?? '' }}</td>
                  <td>{{ $payees[$key] ?? '' }}</td>
                  <td>{{ $paidTo[$key] ?? '' }}</td>
                  <td style="font-size: 13px;">{{ $descriptions[$key] ?? '' }}</td>
                  <td>{{ $amounts[$key] ?? 0 }}</td>
              </tr>
              @php
                  $totalAmount += isset($amounts[$key]) ? $amounts[$key] : 0;
              @endphp
          @empty
              <tr>
                  <td colspan="6">No vouchers available</td>
              </tr>
          @endforelse

          <tr>
              <td colspan="5" style="text-align: center; border: 1px solid #000; padding: 5px;"><strong>Total:</strong></td>
              <td style='border: 1px solid #000; padding: 5px;'>{{ $totalAmount }}</td>
          </tr>
      </tbody>

</table>

<div style="border-bottom: 1px dotted #000; width: 100%; margin-top: 20px;">
    <div style="border-bottom: 2px dotted #000; width: 100%; margin-top: 10px;"></div>
</div>

<div style="margin-top: 75px;">
    <div style="width: 100%;">
        <div style="width: 20%; float: left; text-align: center; margin-bottom: 10px;">
            Received By<br>
            <div style="height: 20px;"></div>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: 80%;">&nbsp;</span>
        </div>
        <div style="width: 20%; float: left; text-align: center; margin-bottom: 10px;">
            Manager<br>
            <div style="height: 20px;"></div>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: 80%;">&nbsp;</span>
        </div>
        <div style="width: 20%; float: left; text-align: center; margin-bottom: 10px;">
            Chief Accountant<br>
            <div style="height: 20px;"></div>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: 80%;">&nbsp;</span>
        </div>
        <div style="width: 20%; float: left; text-align: center; margin-bottom: 10px;">
            General Manager<br>
            <div style="height: 20px;"></div>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: 80%;">&nbsp;</span>
        </div>
        <div style="width: 20%; float: left; text-align: center; margin-bottom: 10px;">
            Director<br>
            <div style="height: 20px;"></div>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: 80%;">&nbsp;</span>
        </div>
    </div>
</div>

</body>
</html>
