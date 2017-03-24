<section>
    <h2><?= __('Add New Debt'); ?></h2>
<form data-ng-submit="$ctrl.addDebt()">
    <div class="form-group">
        <label for="name"><?= __('Name'); ?></label>
        <input type="text" id="name" name="name" data-ng-model="$ctrl.form.name">
    </div>
    <div class="form-group">
        <label for="balance"><?= __('Balance'); ?></label>
        <input type="number" id="balance" name="balance" data-ng-model="$ctrl.form.balance">
    </div>
    <div class="form-group">
        <label for="interest"><?= __('Interest'); ?></label>
        <input type="number" id="interest" name="interest" data-ng-model="$ctrl.form.interest">
    </div>
    <div class="form-group">
        <label for="type"><?= __('Type'); ?></label>
        <select name="type" id="type" data-ng-model="$ctrl.form.type">
            <option value="">Select one</option>
            <option value="paid"><?=  __('Paid'); ?></option>
            <option value="unpaid"><?=  __('Unpaid'); ?></option>
        </select>
    </div>

    <div class="form-group">
        <input type="submit" value="Submit" />
    </div>

</form>
</section>