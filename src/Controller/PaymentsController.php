<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $payments = $this->paginate($this->Payments);

        $this->set(compact('payments'));
        $this->set('_serialize', ['payments']);
    }

    /**
     * View method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => []
        ]);

        $this->set('payment', $payment);
        $this->set('_serialize', ['payment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payment = $this->Payments->newEntity();

        if ($this->request->is('post')) {

            $this->loadModel('Debts');
            $debt = $this->Debts->find()
                ->contain(['Payments'])
                ->where(['id' => $this->request->getData('debt_id')])
                ->first();

            if (null == $debt) {
                return null;
            }

            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            $spread = $debt->interest - $payment->amount;

            if ($spread >= 0) {
                $debt->interest = $spread;
            } else {
                $debt->interest = 0;
                $debt->balance = $debt->balance + $spread;
            }

            if ($this->Payments->save($payment) && $this->Debts->save($debt)) {
                $debt = $this->Debts->find()
                    ->contain(['Payments'])
                    ->where(['id' => $this->request->getData('debt_id')])
                    ->first();
                if (!$this->request->accepts('application/json')) {
                    $this->Flash->success(__('The payment has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
            }

            if (!$this->request->accepts('application/json')) {
                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
            }

        }

        $this->set(compact('debt'));
        $this->set('_serialize', ['debt']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
        }
        $this->set(compact('payment'));
        $this->set('_serialize', ['payment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /*
     * Load payment form
     */
    public function getPaymentForm()
    {
        $this->render('/Element/forms/payment', 'ajax');
    }
}
