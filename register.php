<?php
// Check the registration fields on the server.
$phpErrors = [];
$phpSuccess = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (!isset($_POST['name']) || $name === '') {
        $phpErrors[] = 'Name is required.';
    } elseif (!preg_match('/^[a-zA-Z ]*$/', $name)) {
        $phpErrors[] = 'Name may contain only letters and white space.';
    }

    if ($username === '') {
        $phpErrors[] = 'Username is required.';
    } elseif (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $username)) {
        $phpErrors[] = 'Username must be 3–20 characters and contain only letters, numbers, and underscores.';
    }

    if ($email === '') {
        $phpErrors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $phpErrors[] = 'Invalid email format.';
    }

    if ($password === '') {
        $phpErrors[] = 'Password is required.';
    } elseif (strlen($password) < 8 || strlen($password) > 30) {
        $phpErrors[] = 'Password must be between 8 and 30 characters.';
    }

    if ($confirmPassword === '') {
        $phpErrors[] = 'Please confirm your password.';
    } elseif ($password !== $confirmPassword) {
        $phpErrors[] = 'Passwords do not match.';
    }

    $phpSuccess = !$phpErrors;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register | Bikini Bottom</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    >

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Corinthia:wght@400;700&family=Kalnia:wght@100..700&family=Quicksand:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Page styles -->
    <link rel="stylesheet" href="style.css">

</head>

<body class="auth-page">

<main class="auth-container register-container">

    <div class="auth-card">

        <!-- Icon -->

        <div class="auth-icon">

            <i class="bi bi-person-plus-fill"></i>

        </div>

        <!-- Title -->

        <p class="auth-eyebrow">
            WELCOME TO BIKINI BOTTOM
        </p>

        <h1 class="kalnia-font">
            Create Account
        </h1>

        <p class="auth-description">
            Register now and join the underwater adventure.
        </p>

        <?php if ($phpErrors): ?>
            <div class="login-message login-error" role="alert" style="display:block;">
                <?php foreach ($phpErrors as $error): ?>
                    <p class="mb-1"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Register Form -->

        <form id="registerForm" method="post" action="register.php" novalidate>

            <!-- Name -->

            <div class="auth-field">

                <label
                    for="name"
                    class="form-label"
                >
                    Name
                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-person"></i>

                    </span>

                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="Enter your name"
                        autocomplete="name"
                    >

                </div>

            </div>

            <!-- Username -->

            <div class="auth-field">

                <label
                    for="registerUsername"
                    class="form-label"
                >
                    Username
                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-at"></i>

                    </span>

                    <input
                        type="text"
                        class="form-control"
                        id="registerUsername"
                        name="username"
                        placeholder="Create a username"
                        autocomplete="username"
                    >

                </div>

            </div>

            <!-- Email -->

            <div class="auth-field">

                <label
                    for="email"
                    class="form-label"
                >
                    Email
                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-envelope"></i>

                    </span>

                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        autocomplete="email"
                    >

                </div>

            </div>

            <!-- Password -->

            <div class="auth-field">

                <label
                    for="registerPassword"
                    class="form-label"
                >
                    Password
                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-lock"></i>

                    </span>

                    <input
                        type="password"
                        class="form-control"
                        id="registerPassword"
                        name="password"
                        placeholder="Create a password"
                        autocomplete="new-password"
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        id="toggleRegisterPassword"
                        aria-label="Show password"
                        style="display: none;"
                    >

                        <i class="bi bi-eye-slash"></i>

                    </button>

                </div>

            </div>

            <!-- Confirm Password -->

            <div class="auth-field">

                <label
                    for="confirmPassword"
                    class="form-label"
                >
                    Confirm Password
                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-shield-lock"></i>

                    </span>

                    <input
                        type="password"
                        class="form-control"
                        id="confirmPassword"
                        name="confirmPassword"
                        placeholder="Confirm your password"
                        autocomplete="new-password"
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        id="toggleConfirmPassword"
                        aria-label="Show password"
                        style="display: none;"
                    >

                        <i class="bi bi-eye-slash"></i>

                    </button>

                </div>

            </div>

            <!-- Submit -->

            <button
                type="submit"
                class="btn btn-spongebob auth-submit"
            >

                <i class="bi bi-person-plus"></i>

                Create Account

            </button>

            <!-- Success -->

            <div
                id="registerSuccess"
                class="success-message"
                role="alert"
                <?php if ($phpSuccess) echo 'style="display:block;"'; ?>
            >
                Registration successful! You can now log in.
            </div>

        </form>

        <!-- Bottom -->

        <div class="auth-bottom">

            <p>

                Already have an account?

                <a href="login.php">
                    Login here
                </a>

            </p>

            <a
                href="index.php"
                class="back-home"
            >

                <i class="bi bi-arrow-left"></i>

                Back to Home

            </a>

        </div>

    </div>

</main>

<!-- jQuery -->

<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
></script>

<!-- jQuery Validation -->

<script
    src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"
></script>

<!-- Bootstrap CSS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

<script>

$(document).ready(function () {

            // Continue the original success flow after PHP validation.
            const serverRegistrationSucceeded = <?= $phpSuccess ? 'true' : 'false' ?>;
            if (serverRegistrationSucceeded) {
                setTimeout(function () {
                    window.location.href = "login.php";
                }, 1200);
            }

    $.validator.addMethod(
        "pattern",
        function (value, element, param) {

            if (this.optional(element)) {
                return true;
            }

            return param.test(value);

        },
        "Invalid format."
    );

    function togglePassword(buttonId, inputId) {

        $("#" + buttonId).on("click", function () {

            const input = $("#" + inputId);
            const icon = $(this).find("i");

            if (input.attr("type") === "password") {

                input.attr("type", "text");

                icon
                    .removeClass("bi-eye-slash")
                    .addClass("bi-eye");

                $(this).attr(
                    "aria-label",
                    "Hide password"
                );

            } else {

                input.attr("type", "password");

                icon
                    .removeClass("bi-eye")
                    .addClass("bi-eye-slash");

                $(this).attr(
                    "aria-label",
                    "Show password"
                );

            }

        });

    }

    togglePassword(
        "toggleRegisterPassword",
        "registerPassword"
    );

    togglePassword(
        "toggleConfirmPassword",
        "confirmPassword"
    );

    $("#registerPassword").on("focus", function () {

        $("#toggleRegisterPassword").show();

    });

    $("#confirmPassword").on("focus", function () {

        $("#toggleConfirmPassword").show();

    });

    $("#registerForm").validate({

        errorElement: "div",

        errorClass: "custom-error",

        validClass: "input-success",

        errorPlacement: function (
            error,
            element
        ) {

            error.insertAfter(
                element.closest(".input-group")
            );

        },

        highlight: function (element) {

            $(element)
                .addClass("input-error")
                .removeClass("input-success");

        },

        unhighlight: function (element) {

            $(element)
                .removeClass("input-error")
                .addClass("input-success");

        },

        rules: {

            name: {

                required: true,

                minlength: 3,

                maxlength: 50,

                pattern:
                    /^[A-Za-zÀ-ÿ]+(?:[ '-][A-Za-zÀ-ÿ]+)*$/

            },

            username: {

                required: true,

                minlength: 4,

                maxlength: 20,

                pattern:
                    /^[A-Za-z0-9_]+$/

            },

            email: {

                required: true,

                email: true,

                maxlength: 100

            },

            password: {

                required: true,

                minlength: 8,

                maxlength: 30

            },

            confirmPassword: {

                required: true,

                equalTo: "#registerPassword"

            }

        },

        messages: {

            name: {

                required:
                    "Name is required.",

                minlength:
                    "Name must be at least 3 characters.",

                maxlength:
                    "Name must not exceed 50 characters.",

                pattern:
                    "Name may only contain letters, spaces, apostrophes, and hyphens."

            },

            username: {

                required:
                    "Username is required.",

                minlength:
                    "Username must be at least 4 characters.",

                maxlength:
                    "Username must not exceed 20 characters.",

                pattern:
                    "Username may only contain letters, numbers, and underscores."

            },

            email: {

                required:
                    "Email is required.",

                email:
                    "Please enter a valid email address.",

                maxlength:
                    "Email must not exceed 100 characters."

            },

            password: {

                required:
                    "Password is required.",

                minlength:
                    "Password must be at least 8 characters.",

                maxlength:
                    "Password must not exceed 30 characters."

            },

            confirmPassword: {

                required:
                    "Please confirm your password.",

                equalTo:
                    "Passwords do not match."

            }

        },

        submitHandler: function (form) {

            const name =
                $("#name").val().trim();

            const username =
                $("#registerUsername").val().trim();

            const email =
                $("#email").val().trim();

            const password =
                $("#registerPassword").val();

            localStorage.setItem(
                "registeredName",
                name
            );

            localStorage.setItem(
                "registeredUsername",
                username
            );

            localStorage.setItem(
                "registeredEmail",
                email
            );

            localStorage.setItem(
                "registeredPassword",
                password
            );

            // Send the form to PHP for server-side validation.
            form.submit();
            return;

            $("#registerSuccess")
                .stop(true, true)
                .hide()
                .slideDown();

            form.reset();

            $("#registerForm input")
                .removeClass(
                    "input-success input-error"
                );

            $("#registerPassword")
                .attr("type", "password");

            $("#confirmPassword")
                .attr("type", "password");

            $("#toggleRegisterPassword")
                .find("i")
                .removeClass("bi-eye")
                .addClass("bi-eye-slash");

            $("#toggleConfirmPassword")
                .find("i")
                .removeClass("bi-eye")
                .addClass("bi-eye-slash");

            $("#toggleRegisterPassword")
                .attr(
                    "aria-label",
                    "Show password"
                );

            $("#toggleConfirmPassword")
                .attr(
                    "aria-label",
                    "Show password"
                );

            $("#toggleRegisterPassword").hide();

            $("#toggleConfirmPassword").hide();

            setTimeout(function () {

                window.location.href =
                    "login.php";

            }, 1200);

            return false;

        }

    });

$("#name").on("keydown", function (event) {

    if (event.key !== "Enter") {
        return;
    }

    event.preventDefault();

    const isValid =
        $("#registerForm")
            .validate()
            .element("#name");

    if (!isValid) {

        $("#registerForm")
            .validate()
            .form();

        $("#name").focus();

        return false;
    }

    $("#registerUsername").focus();

    return false;

});

$("#registerUsername").on("keydown", function (event) {

    if (event.key !== "Enter") {
        return;
    }

    event.preventDefault();

    const isValid =
        $("#registerForm")
            .validate()
            .element("#registerUsername");

    if (!isValid) {

        $("#registerForm")
            .validate()
            .form();

        $("#registerUsername").focus();

        return false;
    }

    $("#email").focus();

    return false;

});

$("#email").on("keydown", function (event) {

    if (event.key !== "Enter") {
        return;
    }

    event.preventDefault();

    const isValid =
        $("#registerForm")
            .validate()
            .element("#email");

    if (!isValid) {

        $("#registerForm")
            .validate()
            .form();

        $("#email").focus();

        return false;
    }

    $("#registerPassword").focus();

    return false;

});

$("#registerPassword").on("keydown", function (event) {

    if (event.key !== "Enter") {
        return;
    }

    event.preventDefault();

    const isValid =
        $("#registerForm")
            .validate()
            .element("#registerPassword");

    if (!isValid) {

        $("#registerForm")
            .validate()
            .form();

        $("#registerPassword").focus();

        return false;
    }

    $("#confirmPassword").focus();

    return false;

});

$("#confirmPassword").on("keydown", function (event) {

    if (event.key !== "Enter") {
        return;
    }

    event.preventDefault();

    const formIsValid =
        $("#registerForm").valid();

    if (!formIsValid) {

        $("#confirmPassword").focus();

        return false;
    }

    $("#registerForm").submit();

    return false;

});

});

</script>

</body>
</html>

