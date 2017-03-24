<div class="bg-container"></div>
<div class="modal-window">
    <button class="close-window" data-ng-click="$ctrl.closeModal($event)">x</button>
<section class="form-action payment">
    <h2><?= __('Add New Payment'); ?></h2>
<form data-ng-submit="$ctrl.addPayment()">
    <div class="form-group">
        <label for="amount"><?= __('Amount'); ?></label>
        <input type="number" id="amount" name="amount" data-ng-model="$ctrl.formPayment.amount">
    </div>
    <div class="form-group">
        <input type="submit" value="Submit" />
    </div>
</form>
</section>
</div>