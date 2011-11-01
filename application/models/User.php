<?php
class Application_Model_User extends Dm_Model_Abstract
{   
    public function getUserById($id)
    {
        $id = (int) $id;
        return $this->getResource('User')->getUserById($id);
    }

    public function getUserByEmail($email, $ignoreUser=null)
    {
        return $this->getResource('User')->getUserByEmail($email, $ignoreUser);
    }
    
    public function getUsers($paged=null, $order=null)
    {
        return $this->getResource('User')->getUsers($paged, $order);
    }

    public function registerUser($post)
    {
        $form = $this->getForm('userRegister');
        return $this->save($form, $post, array('role' => 'user'));
    }

    public function saveUser($post)
    {
        //check user role here so that we can lock customers
        //to their userId only maybe use the auth or acl?
        $form = $this->getForm('userEdit');
        return $this->save($form, $post);
    }
    
    protected function save($form, $info, $defaults=array())
    {       
        if (!$form->isValid($info)) {
            return false;
        }

        // get filtered values
        $data = $form->getValues();

        // password hashing
        if (array_key_exists('password', $data) && '' != $data['password']) {
            $data['salt'] = sha1($this->createSalt());
            $data['password'] = sha1(sha1($data['password']) . $data['salt']);
        } else {
            unset($data['password']);
        }

        // apply any defaults
        foreach ($defaults as $col => $value) {
            $data[$col] = $value;
        }

        $user = array_key_exists('userId', $data) ?
            $this->getResource('User')->getUserById($data['userId']) : null;

        return $this->getResource('User')->saveRow($data, $user);
    }

	/**
     * Create a random salt
     * 
     * @return string
     */
    private function createSalt()
    {
        $salt = '';
        for ($i = 0; $i < 50; $i++) {
            $salt .= chr(rand(33, 126));
        }
        return $salt;
    }
}