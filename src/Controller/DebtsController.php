<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Debts Controller
 *
 * @property \App\Model\Table\DebtsTable $Debts
 */
class DebtsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $debts = $this->Debts->find('all')->contain(['Payments']);
        $this->set('title', __('Debt Collection'));
        $this->set(compact('debts'));
        $this->set('_serialize', ['debts']);
    }

    /**
     * View method
     *
     * @param string|null $id Debt id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $debt = $this->Debts->get($id, [
            'contain' => ['Payments']
        ]);

        $this->set('debt', $debt);
        $this->set('_serialize', ['debt']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $debt = $this->Debts->newEntity();
        if ($this->request->is('post')) {
            $debt = $this->Debts->patchEntity($debt, $this->request->getData());
            if ($this->Debts->save($debt)) {
                $this->Flash->success(__('The debt has been saved.'));
                if (!$this->request->accepts('application/json')) {
                    return $this->redirect(['action' => 'index']);
                }
            }
            if (!$this->request->accepts('application/json')) {
                $this->Flash->error(__('The debt could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('debt'));
        $this->set('_serialize', ['debt']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Debt id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $debt = $this->Debts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $debt = $this->Debts->patchEntity($debt, $this->request->getData());
            if ($this->Debts->save($debt)) {
                $this->Flash->success(__('The debt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The debt could not be saved. Please, try again.'));
        }
        $this->set(compact('debt'));
        $this->set('_serialize', ['debt']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Debt id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $debt = $this->Debts->get($id);
        if ($this->Debts->delete($debt)) {
            $this->Flash->success(__('The debt has been deleted.'));
        } else {
            $this->Flash->error(__('The debt could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Load Form for AngularJS
     */
    public function loadForm()
    {
        $this->render('/Element/forms/debt', 'ajax');
    }

}
