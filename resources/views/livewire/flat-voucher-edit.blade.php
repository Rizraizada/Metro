<!-- resources/views/livewire/flat-voucher-edit.blade.php -->

<div>
    <!-- Your Livewire edit form content -->
    <form wire:submit.prevent="update">
        <!-- Your form fields and code -->
        <div class="form-group">
            <label for="category">Category:</label>
            <select wire:model="flatvoucher.category" class="form-control" required>
                <option value="expense">Income</option>
                <option value="income">Expense</option>
            </select>
        </div>

        <!-- Other form fields -->

        <button type="submit">Save Changes</button>
    </form>
</div>
