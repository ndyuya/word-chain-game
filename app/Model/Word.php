<?php
class Word extends AppModel {
    public $name = 'Word';
    public $belongsTo = array('Game' => array(
        'className' => 'Game',
        'foreignKey' => 'game_id',
        'counterCache' => true,
    ));
    public $validate = array(
        'pronunciation' => array(
            'rule1' => array(
                'rule' => array('custom', '/^(?:\xE3\x81[\x81-\xBF]|\xE3\x82[\x80-\x93])+$/'),
                'message' => '読みは「ひらがな」で入力してください'
            ),
            'rule2' => array(
                'rule' => 'wordChain',
                'message' => '「しりとり」が成立していません'
            ),
        )
    );

    public function wordChain($pronunciation) {
        $last_answer = $this->find('first', array('conditions' => array('Word.game_id' => $this->data['Word']['game_id']), 'order' => 'Word.turn DESC'));

        if(empty($last_answer)) {
            return true;
        }

        if(mb_substr($this->data['Word']['pronunciation'], 0, 1, 'UTF-8') !== mb_substr($last_answer['Word']['pronunciation'], -1, 1, 'UTF-8')) {
            $this->lastErrorMessage = '「しりとり」が成立していません';
            return false;
        }

        return true;
    }
}
