<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/validate.php';

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function post_field(string $key): string
{
    $v = $_POST[$key] ?? '';
    return is_string($v) ? trim($v) : '';
}

$values = ['name' => '', 'email' => '', 'message' => ''];
$errors = [];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    foreach (array_keys($values) as $field) {
        $values[$field] = post_field($field);
    }

    if (!validate_required($values['name'])) {
        $errors['name'] = 'Name is required.';
    } elseif (!validate_length($values['name'], 2, 60)) {
        $errors['name'] = 'Name must be between 2 and 60 characters.';
    }

    if (!validate_required($values['email'])) {
        $errors['email'] = 'Email is required.';
    } elseif (!validate_email($values['email'])) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if (!validate_required($values['message'])) {
        $errors['message'] = 'Message is required.';
    } elseif (!validate_length($values['message'], 10, 1000)) {
        $errors['message'] = 'Message must be between 10 and 1000 characters.';
    }

    if ($errors === []) {
        header('Location: success.php', true, 303);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Contact Us</title>
</head>
<body>
  <h1>Contact Us</h1>

  <?php if ($errors !== []): ?>
  <p class="error">Please fix the errors below.</p>
  <?php endif; ?>


  <form method="post" action="index.php" novalidate>
    <label>Name
      <input type="text" name="name" value="<?= e($values['name']) ?>">
    </label>
    <?php if (isset($errors['name'])): ?><span class="error"><?= e($errors['name']) ?></span><?php endif; ?>
    <br>

    <label>Email
      <input type="email" name="email" value="<?= e($values['email']) ?>">
    </label>
    <?php if (isset($errors['email'])): ?><span class="error"><?= e($errors['email']) ?></span><?php endif; ?>
    <br>

    <label>Message
      <textarea name="message"><?= e($values['message']) ?></textarea>
    </label>
    <?php if (isset($errors['message'])): ?><span class="error"><?= e($errors['message']) ?></span><?php endif; ?>
    <br>

    <button type="submit">Send</button>
  </form>
</body>
</html>
