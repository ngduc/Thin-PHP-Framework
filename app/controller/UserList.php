<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/model/User.php';
require_once BASE.'/app/model/base/DAOs.php';

class UserList extends BaseController
{
	public function view()
	{
		$dao = DAOs::getUserDAO();
		
		if (isset($this->params[0]) && trim($this->params[0])=='remove')
		{
			// ex: requesting: /user-list/p/delete/2
			$id = trim(sanitize_str($this->params[1]));
			$dao->removeById($id);
		}
		else if (isset($this->params[0]) && trim($this->params[0])=='add')
		{
			$randNum = mt_rand(0, 99999);
			$newUser = new User(
							array('firstName' => 'First', 'lastName' => 'LastName',
							'username' => "test$randNum", 'email' => "test$randNum@example.com")
						);			
			// #TODO: implement UserDao.create($newUser) instead.
			$dbNow = date( 'Y-m-d H:i:s' );
			$dao->execute("INSERT INTO user(firstName, lastName, username, email, createdTime)
						VALUES(:firstName, :lastName, :username, :email, '$dbNow')", $newUser->getFields());
		}
		
		$users = $dao->getAll();
				
        $v = $this->smarty;
        $v->assign('title', 'User List');

        $v->assign('inc_content', v('user_list.html'));
        $v->assign('users', $users);
        $v->assign('totalUsers', $dao->countAll());
        
        $this->display($v, v('index.html'));
	}
}
?>
