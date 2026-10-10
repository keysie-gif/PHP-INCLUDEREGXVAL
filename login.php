<?php
// Check the login fields before continuing.
$phpErrors = [];
$phpMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '') {
        $phpErrors[] = 'Username is required.';
    } elseif (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $username)) {
        $phpErrors[] = 'Username must be 3–20 characters and contain only letters, numbers, and underscores.';
    }

    if ($password === '') {
        $phpErrors[] = 'Password is required.';
    } elseif (strlen($password) < 8 || strlen($password) > 30) {
        $phpErrors[] = 'Password must be between 8 and 30 characters.';
    }

    if (!$phpErrors && ($_POST['clientLoginVerified'] ?? '') === '1') {
        // The demo account is saved in the browser's localStorage.
        // PHP checks the input, while JavaScript checks the saved account.
        header('Location: index.php');
        exit;
    } elseif (!$phpErrors) {
        $phpMessage = 'The input format is valid. Use the registered account in this browser to complete the demo login.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Bikini Bottom</title>

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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Corinthia:wght@400;700&family=Kalnia:wght@100..700&family=Quicksand:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Page styles -->
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">

    <main class="auth-container">

        <div class="auth-card">

            <!-- Icon -->
            <div class="auth-icon">
                <i class="bi bi-person-fill"></i>
            </div>

            <!-- Title -->
            <p class="auth-eyebrow">
                WELCOME TO BIKINI BOTTOM
            </p>

            <h1 class="kalnia-font">
                Welcome Back
            </h1>

            <p class="auth-description">
                Login to continue your underwater adventure.
            </p>

            <!-- Login form -->
            <form id="loginForm" method="post" action="login.php" novalidate>

                <input type="hidden" name="clientLoginVerified" id="clientLoginVerified" value="0">

                <!-- Username -->
                <div class="auth-field">

                    <label for="username" class="form-label">
                        Username
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>

                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username"
                            placeholder="Enter your username"
                            autocomplete="username"
                        >

                    </div>

                </div>

                <!-- Password -->
                <div class="auth-field">

                    <label for="loginPassword" class="form-label">
                        Password
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input
                            type="password"
                            class="form-control"
                            id="loginPassword"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="toggleLoginPassword"
                            aria-label="Show password"
                            style="display: none;"
                        >
                            <i class="bi bi-eye-slash"></i>
                        </button>

                    </div>

                </div>

                <!-- Remember and forgot password -->
                <div class="login-options">

                    <div class="form-check">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="remember"
                        >

                        <label
                            class="form-check-label"
                            for="remember"
                        >
                            Remember Me
                        </label>

                    </div>

                    <a
                        href="#"
                        class="forgot-link"
                        id="forgotPassword"
                    >
                        Forgot Password?
                    </a>

                </div>

                <!-- Login attempts -->
                <div
                    id="attemptsText"
                    class="attempt-message"
                >
                    Attempts left: 4
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    id="loginButton"
                    class="btn btn-spongebob auth-submit"
                >
                    <i class="bi bi-box-arrow-in-right"></i>
                    Login
                </button>

                <!-- Login message -->
                <div
                    id="loginMessage"
                    class="login-message"
                    role="alert"
                    <?php if ($phpErrors || $phpMessage !== '') echo 'style="display:block;"'; ?>
                >
                    <?php
                    if ($phpErrors) {
                        echo '<span class="login-error">' . implode('<br>', array_map(
                            fn($error) => htmlspecialchars($error, ENT_QUOTES, 'UTF-8'),
                            $phpErrors
                        )) . '</span>';
                    } elseif ($phpMessage !== '') {
                        echo '<span class="login-error">' . htmlspecialchars($phpMessage, ENT_QUOTES, 'UTF-8') . '</span>';
                    }
                    ?>
                </div>

            </form>

            <!-- Register link -->
            <div class="auth-bottom">

                <p>
                    Don't have an account?
                    <a href="register.php">
                        Register here
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- jQuery Validation -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        $(document).ready(function () {

            let attempts = 4;

            $("#toggleLoginPassword").on("click", function () {

                const password = $("#loginPassword");
                const icon = $(this).find("i");

                if (password.attr("type") === "password") {

                    password.attr("type", "text");

                    icon
                        .removeClass("bi-eye-slash")
                        .addClass("bi-eye");

                    $(this).attr("aria-label", "Hide password");

                } else {

                    password.attr("type", "password");

                    icon
                        .removeClass("bi-eye")
                        .addClass("bi-eye-slash");

                    $(this).attr("aria-label", "Show password");

                }

            });

            $("#loginPassword").on("focus", function () {

                $("#toggleLoginPassword").show();

            });

            const rememberedUsername =
                localStorage.getItem("rememberedUsername");

            if (rememberedUsername) {

                $("#username").val(rememberedUsername);

                $("#remember").prop("checked", true);

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

            $("#loginForm").validate({

                errorElement: "div",

                errorClass: "custom-error",

                validClass: "input-success",

                errorPlacement: function (error, element) {

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

                    username: {

                        required: true,

                        minlength: 4,

                        maxlength: 20,

                        pattern: /^[A-Za-z0-9_]+$/

                    },

                    password: {

                        required: true,

                        minlength: 8,

                        maxlength: 30

                    }

                },

                messages: {

                    username: {

                        required: "Username is required.",

                        minlength:
                            "Username must be at least 4 characters.",

                        maxlength:
                            "Username must not exceed 20 characters.",

                        pattern:
                            "Username may only contain letters, numbers, and underscores."

                    },

                    password: {

                        required: "Password is required.",

                        minlength:
                            "Password must be at least 8 characters.",

                        maxlength:
                            "Password must not exceed 30 characters."

                    }

                },

                submitHandler: function (form) {

                    if (attempts <= 0) {

                        showLoginMessage(
                            "No attempts left. Login is disabled.",
                            "error"
                        );

                        return false;

                    }

                    const username =
                        $("#username").val().trim();

                    const password =
                        $("#loginPassword").val();

                    const savedUsername =
                        localStorage.getItem("registeredUsername");

                    const savedPassword =
                        localStorage.getItem("registeredPassword");

                    if (
                        username === savedUsername &&
                        password === savedPassword
                    ) {

                        if ($("#remember").is(":checked")) {

                            localStorage.setItem(
                                "rememberedUsername",
                                username
                            );

                        } else {

                            localStorage.removeItem(
                                "rememberedUsername"
                            );

                        }

                        localStorage.setItem(
                            "loggedInUser",
                            username
                        );

                        showLoginMessage(
                            "Login successful!",
                            "success"
                        );

                        // Send the validated form to PHP as well.
                        $("#clientLoginVerified").val("1");
                        form.submit();

                        return false;

                    }

                    attempts--;

                    $("#attemptsText")
                        .text("Attempts left: " + attempts)
                        .toggleClass(
                            "attempt-danger",
                            attempts <= 2
                        );

                    $("#loginPassword")
                        .val("")
                        .attr("type", "password")
                        .removeClass("input-success")
                        .removeClass("input-error");

                    $("#toggleLoginPassword")
                        .find("i")
                        .removeClass("bi-eye")
                        .addClass("bi-eye-slash");

                    $("#toggleLoginPassword")
                        .attr("aria-label", "Show password");

                    showLoginMessage(
                        "Incorrect username or password.",
                        "error"
                    );

                    if (attempts <= 0) {

                        $("#attemptsText")
                            .text("No attempts left.")
                            .addClass("attempt-danger");

                        $("#loginButton")
                            .prop("disabled", true);

                        $("#username")
                            .prop("disabled", true);

                        $("#loginPassword")
                            .prop("disabled", true);

                        $("#remember")
                            .prop("disabled", true);

                    }

                }

            });

            $("#username").on("keydown", function (event) {

                if (event.key !== "Enter") {
                    return;
                }

                event.preventDefault();

                const usernameIsValid =
                    $("#loginForm")
                        .validate()
                        .element("#username");

                if (!usernameIsValid) {

                    $("#loginForm")
                        .validate()
                        .element("#loginPassword");

                    $("#username").focus();

                    return false;

                }

                $("#loginPassword").focus();

                return false;

            });

            $("#loginPassword").on("keydown", function (event) {

                if (event.key !== "Enter") {
                    return;
                }

                event.preventDefault();

                const formIsValid =
                    $("#loginForm").valid();

                if (!formIsValid) {

                    const usernameIsValid =
                        $("#loginForm")
                            .validate()
                            .element("#username");

                    if (!usernameIsValid) {

                        $("#username").focus();

                    } else {

                        $("#loginPassword").focus();

                    }

                    return false;

                }

                $("#loginForm").submit();

                return false;

            });

            function showLoginMessage(message, type) {

                const box = $("#loginMessage");

                box
                    .removeClass(
                        "login-success login-error"
                    )
                    .addClass(
                        type === "success"
                            ? "login-success"
                            : "login-error"
                    )
                    .text(message)
                    .stop(true, true)
                    .hide()
                    .slideDown();

            }

            $("#forgotPassword").on("click", function (event) {

                event.preventDefault();

                const savedUsername =
                    localStorage.getItem("registeredUsername");

                if (!savedUsername) {

                    showLoginMessage(
                        "No registered account was found.",
                        "error"
                    );

                    return;

                }

                showLoginMessage(
                    "Please use your registered account details to login.",
                    "error"
                );

            });

        });

    </script>

</body>
</html>
