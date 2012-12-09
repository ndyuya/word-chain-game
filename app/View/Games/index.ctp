<div class="row">
  <div class="span3 offset9">
    <?php echo $this->Html->link('「しりとり」を新しく始める', array('controller' => 'games', 'action' => 'create'), array('class' => 'btn btn-primary')); ?>
  </div>
</div>
<br />
<div class="row">
  <div class="span12">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>オーナー</th>
          <th>回答数</th>
          <th>ゲーム内容を表示する</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($games as $game) { ?>
        <tr>
          <td><?php echo $game['Game']['id']; ?></td>
          <td><?php echo $this->Html->image('https://graph.facebook.com/'.$game['Game']['owner_user_id'].'/picture', array('alt' => $game['Game']['owner_user_name'], 'title' => $game['Game']['owner_user_name'])); ?></td>
          <td><?php echo $game['Game']['word_count']; ?></td>
          <td><?php 
            if($game['Game']['is_active'] === true) { 
              echo $this->Html->link('継続中', array('controller' => 'games', 'action' => 'answer', $game['Game']['id']), array('class' => 'btn btn-success'));
            } else {
              echo $this->Html->link('終了', array('controller' => 'games', 'action' => 'answer', $game['Game']['id']), array('class' => 'btn btn-danger'));
            }
          ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>
