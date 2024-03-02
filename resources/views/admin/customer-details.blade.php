
<div class="row">
    <div class="col-md-3 mb-4">
        <label class="form-label">Name:</label>
        <div class="form-input">{{ $customer->name }}</div>
    </div>
    <div class="col-md-3 mb-4">
        <label class="form-label">Phone:</label>
        <div class="form-input">{{ $customer->phone }}</div>
    </div>
    <div class="col-md-3 mb-4">
        <label class="form-label">Email:</label>
        <div class="form-input">{{ $customer->email }}</div>
    </div>
    <div class="col-md-3 mb-4">
        <label class="form-label">Assigned Company:</label>
        <div class="form-input">{{ $customer->assignedCompany->name }}</div>
    </div>

    <div class="col-md-3 mb-6">
        <label class="form-label">Details:</label>
        <div class="form-input">{{ $customer->details }}</div>
    </div>
    <div class="col-md-3 mb-6">
        <label class="form-label">Total Installment:</label>
        <div class="form-input">{{ $customer->total_installment }}</div>
    </div>
    <div class="col-md-3 mb-6">
        <label class="form-label">Installment:</label>
        <div class="form-input">{{ $customer->installment }}</div>
    </div>


    <div class="col-md-3 mb-6">
        <label class="form-label">Car Park:</label>
        <div class="form-input">{{ $customer->garage }}</div>
    </div>
    <div class="col-md-3 mb-6">
    <label class="form-label">Flat Name:</label>
    <div class="form-input">
    @foreach($customer->flats as $flat)
        {{ $flat->flat_number }}
    @endforeach
    </div>
</div>


</div>


<div class="container">
    <div class="row">
        <div class="col-md-9">
        <table class="table table-bordered" style="margin-top: 15px; margin-left: -14px;">
    <thead>
        <tr>
            <th>Utility Charge</th>
            <th>Delay Charge</th>
            <th>Discount</th>
            <th>Car Money</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="form-group">
                    <input type="number" name="utility_charge" class="form-control utility-charge" value="{{ $customer->utility_charge }}">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" name="delay_charge" class="form-control delay-charge" value="{{ $customer->delay_charge }}">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" name="special_discount" class="form-control discount" value="{{ $customer->special_discount }}">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" name="car_money" class="form-control car-money" value="{{ $customer->car_money }}">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" name="total" class="form-control total" readonly>
                </div>
            </td>
        </tr>
    </tbody>


</div>

    </div>
</div>
<div class="container">
    <h1>Customer Vouchers</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
        @if(!empty($customerVouchers))
    <!-- Loop through and display customer vouchers -->
    @foreach($customerVouchers as $voucher)
        <p>Description: {{ $voucher['description'] }}, Amount: {{ $voucher['amount'] }}</p>
    @endforeach
@else
    <p>No vouchers available</p>
@endif

        </tbody>
    </table>
</div>

</body>
<script>
    // Get input elements
    var utilityChargeInput = document.querySelector('.utility-charge');
    var delayChargeInput = document.querySelector('.delay-charge');
    var discountInput = document.querySelector('.discount');
    var carMoneyInput = document.querySelector('.car-money');
    var totalInput = document.querySelector('.total');

    // Function to calculate total and update the total input
    function calculateTotal() {
        var utilityCharge = parseFloat(utilityChargeInput.value) || 0;
        var delayCharge = parseFloat(delayChargeInput.value) || 0;
        var discount = parseFloat(discountInput.value) || 0;
        var carMoney = parseFloat(carMoneyInput.value) || 0;

        var total = utilityCharge + delayCharge + discount + carMoney;
        totalInput.value = total.toFixed(2); // Adjust decimal places as needed
    }

    // Add event listeners to input elements
    utilityChargeInput.addEventListener('input', calculateTotal);
    delayChargeInput.addEventListener('input', calculateTotal);
    discountInput.addEventListener('input', calculateTotal);
    carMoneyInput.addEventListener('input', calculateTotal);

    // Initial calculation
    calculateTotal();
</script>
</html>



