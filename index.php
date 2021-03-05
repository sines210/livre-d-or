<?php


require_once './class/Message.php';
require_once './class/GuestBook.php';

$errors = null;
$success = false;

$guestbook = new GuestBook (__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'messages');

if(isset($_POST['username'], $_POST['message'])){  
      $message= new Message ($_POST['username'], $_POST['message']);
      if($message->isValid()){
       $guestbook->addMessage($message);
       $success = true;
       $_POST = [];
      }
      else{
          $errors=$message->getErrors();
      }
}
    $messages = $guestbook->getMessages();

    $title="Livre d'Or";

require './components/header.php';
?>

<div class="container">
    <h1>Livre d'or</h1>
    <form action="" method='post'>

    <?php if(!empty($errors)):?>
    <div class='alert alert-danger'>Formulaire invalide </div>
    <?php endif?>
    <?php if($success):?>
    <div class='alert alert-success'>Merci pour votre message </div>
    <?php endif?>

        <div class="form_group">
            <input value="<?= htmlentities($_POST['username']?? '') ?>" type="text" name='username' autocomplete="off" placeholder='Votre pseudo' class="form-control <?php isset($errors['username']) ? 'is-invalid' : '' ?>" />
        </div>
            <?php if(isset($errors['username'])):?>
             <div class='invalid-feedback'> <?= $errors['username'] ?> </div>
             <?php endif ?>
        <div class="form_group">
            <textarea type="text" name='message' placeholder='Votre message' class="form-control <?php isset($errors['message']) ? 'is-invalid' : '' ?>" > <?= htmlentities($_POST['message']?? '') ?> </textarea>
            <?php if(isset($errors['message'])):?>
             <div class='invalid-feedback'> <?= $errors['message'] ?> </div>
             <?php endif ?>
        </div>
            <button class="btn btn-primary">Envoyer</button>
    </form>

    <?php if(!empty($messages)):?>
    <h1 class="mt-4">Vos messages</h1>

    <?php foreach($messages as $message) : ?>
            <?= $message->toHTML() ?>
    <?php endforeach ?>

    <?php endif ?>

  

</div>

<?php require './components/footer.php'?>
