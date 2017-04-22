<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m170409_031556_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(50)->notNull()->unique()->comment('用户名'),
            'password'=>$this->string(50)->notNull()->comment('密码'),
            'tel'=>$this->char(11)->notNull()->comment('电话'),
            'email'=>$this->string(30)->notNull()->unique()->comment('邮箱'),
            'add_time'=>$this->integer(11)->notNull()->comment('添加时间'),
            'last_login_time'=>$this->integer(11)->notNull()->comment('最后登录时间'),
            'last_login_ip'=>$this->integer(15)->comment('最后登录ip'),
            'status'=>$this->smallInteger(4)->comment('状态'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
