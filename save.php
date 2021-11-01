<?php
    require_once("./utils/connection.php");
    require_once("./utils/redirects.php");
    require_once("./utils/validations.php");

    $statement = null;
    $isSubmitted = isset($_POST['submit']);
    $id = intval($_REQUEST['id']);
    $name = $_POST['name'];
    $expiration = $_POST['expiration'];
    $value = $_POST['value'];
    $hasId = hasId($id);
    $message = null;

    if($hasId && $isSubmitted){
        $statement = $connection -> prepare("UPDATE $table set name='$name', value=$value, expiration='$expiration' WHERE id=$id");

        try{
            $statement -> execute();

            $message = "Beer updated";
        } catch(Exception $error){
            showError($error);
        }
    } else if($hasId){
        $statement = $connection -> prepare("SELECT id, name, value, expiration FROM $table WHERE id=$id");

        try{
            $statement -> execute();

            $result = $statement -> fetch(PDO::FETCH_OBJ);

            $name = $result -> name;
            $value = $result -> value;
            $expiration = $result -> expiration;
        } catch(Exception $error){
            showError($error);
        }
    } else if($isSubmitted){
        $statement = $connection -> prepare("INSERT INTO $table(name, value, expiration) VALUES ('$name', $value, '$expiration')");

        try{
            $statement -> execute();

            $message = "Beer created";
        } catch(Exception $error){
            showError($error);
        }
    }

    if($message) toList($message);
?>

<?php require_once("./components/header.php") ?>

<form class="form" name="form" action="./save.php" method="POST">
    <fieldset class="form__fieldset">
        <legend class="form__subtitle subtitle"><?php echo $hasId ? "Edit" : "Create" ?></legend>

        <input value="<?php echo $id ?>" type="hidden" name="id" id="id">

        <div class="field">
            <label class="field__label" for="name">Name</label>
            <input autofocus class="field__input" placeholder="Set name" value="<?php echo $name ?>" type="text" name="name" id="name" maxlength="250" required>
        </div>

        <div class="field">
            <label class="field__label" for="value">Value</label>
            <input class="field__input" placeholder="Set value" value="<?php echo $value ?>" type="number" name="value" id="value" min="0.01" max="9999999999" step="0.01" maxlength="10" required>
        </div>

        <div class="field">
            <label class="field__label" for="expiration">Expiration</label>
            <input class="field__input" value="<?php echo $expiration ?>" type="date" name="expiration" id="expiration" required>
        </div>

        <div class="form__actions">
            <input class="button" value="<?php echo $hasId ? 'Save' : 'Create' ?>" name="submit" type="submit">
            <a class="button" href="index.php" target="_self">Back</a>
        </div>
    </fieldset>
</form>

<?php require_once("./components/footer.php") ?>
