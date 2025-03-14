<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <style>
        /* Import Font */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap');

        /* Style Dasar */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(45deg, #ff9a9e, #fad0c4, #fad0c4, #ffdde1);
            background-size: 300% 300%;
            animation: bgAnimation 10s infinite alternate;
            text-align: center;
            flex-direction: column;
            color: white;
        }

        /* Animasi Background */
        @keyframes bgAnimation {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        /* Efek Teks */
        h1 {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(45deg, #ff8a00, #e52e71);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeIn 1.5s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Efek Typing */
        .typing-container {
            display: inline-block;
            overflow: hidden;
            border-right: 3px solid white;
            font-size: 2.5rem;
            font-weight: bold;
            white-space: nowrap;
            width: 0;
            animation: typing 3s steps(12, end) forwards, blink 0.8s infinite;
        }

        @keyframes typing {
            from { width: 0; }
            to { width: 12ch; } /* Sesuai jumlah karakter 'COMING SOON' */
        }

        @keyframes blink {
            50% { border-color: transparent; }
        }

        /* Countdown Timer */
        .countdown {
            font-size: 1.8rem;
            font-weight: 600;
            margin-top: 10px;
        }

        /* Animasi Floating Button */
        .notify-btn {
            margin-top: 20px;
            background: #ff6a00;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 30px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0px 5px 15px rgba(255, 106, 0, 0.4);
            animation: float 2s ease-in-out infinite;
        }

        .notify-btn:hover {
            background: #e52e71;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

    </style>
</head>
<body>

    <h1>🔥 Get Ready! 🔥</h1>
    <div class="typing-container">COMING SOON</div>
    <div class="countdown" id="countdown"></div>
    <button class="notify-btn" onclick="alert('Kamu akan diberi tahu saat kami rilis!')">Notify Me</button>

    <script>
        // Set tanggal rilis (YYYY, MM (0-indexed), DD)
        const releaseDate = new Date(2025, 3, 1, 0, 0, 0).getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const timeLeft = releaseDate - now;

            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML = 
                `🚀 ${days}d ${hours}h ${minutes}m ${seconds}s 🚀`;

            if (timeLeft < 0) {
                document.getElementById("countdown").innerHTML = "🎉 We're Live! 🎉";
            }
        }

        setInterval(updateCountdown, 1000);
    </script>

</body>
</html>
