<?php


class BuyerController extends AppController {


    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('add');
    }

    public function index() {

    	$cond = array(
                    'available' => '0',
                 );
        $buyerlist  =  $a =  $this->Buyer->find('all',array(
            'conditions' => $cond,
            ));

        $this->set('buyerlist',$buyerlist);

        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->Buyer->id = $id;
        if (!$this->Buyer->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Buyer->create();
            if ($this->Buyer->save($this->request->data)) {
                //$this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->Buyer->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Buyer->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->User->findById($id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        // Prior to 2.5 use
        // $this->request->onlyAllow('post');

        $this->request->allowMethod('post');

        $this->Buyer->id = $id;
        if (!$this->Buyer->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->Buyer->delete()) {
            $this->Flash->success(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

}