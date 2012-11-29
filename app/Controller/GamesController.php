<?php

App::uses('AppController', 'Controller');

class GamesController extends AppController {

	public $uses = array('Game','Word');
    public $facebook;
    public $fb_user;
    public $fb_user_name;

    public function beforeFilter() {
        App::import('Vendor', 'facebook/src/facebook');
        $this->facebook = new Facebook(array(
            'appId' => Configure::read('Facebook.appId'),
            'secret' => Configure::read('Facebook.secret'),
            'cookie' => true,
        ));
        $this->fb_user = $this->facebook->getUser();

        if(empty($this->fb_user)) {
            $this->redirect($this->facebook->getLoginUrl());
        } else {
            $fb_user_info = $this->facebook->api('/'.$this->fb_user);
            $this->fb_user_name = $fb_user_info['name'];
            $this->set('user_id', $this->fb_user);
            $this->set('user_name', $this->fb_user_name);
        }
    }

    public function index() {
        $games = $this->Game->find('all');
        $this->set('games', $games);
    }

    public function create() {
        $this->autoRender = false;
        $this->Game->save(array(
            'owner_user_id' => $this->fb_user,
            'owner_user_name' => $this->fb_user_name,
            'is_active' => 1
        ));
        $this->redirect(array('action'=>'answer' ,$this->Game->id));
    }

    public function answer($game_id) {
        if($this->request->is('post')) {
            if($this->Word->save($this->request->data)) {
                $this->Session->setFlash('回答を登録しました', 'flash_success');
                $this->redirect('/games/answer/'.$game_id);
            } else {
                $this->Session->setFlash('回答の登録に失敗しました', 'flash_error');
            }
        }

        $this->Game->id = $game_id;
        $turn = $this->Game->field('word_count');

        $words = $this->Word->find('all', array('conditions' => array('Word.game_id' => $game_id), 'order' => 'Word.turn'));

        $this->set('game_id', $game_id);
        $this->set('turn', $turn + 1);
        $this->set('words', $words);
    }
}
