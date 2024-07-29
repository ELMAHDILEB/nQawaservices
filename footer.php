<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>footer</title>
    <style>
        /* Footer START */
#footer {
    width: 100%;
    height: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: var(--color-first);
    color: var(--color-black);
    gap: 50px;
    margin-top: 190px;

}

.all__footer {
    width: 80%;
    min-height: 100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, auto));
    gap: 1em;
    overflow: hidden;
    padding: 2%;
    align-items: start;
}

.news__letter {
    height: 10.5em;
    display: block;
    text-align: center;
}

.news__letter input {
    border: none;
    outline: none;
    width: 300px;
    height: 2.5em;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 20px;
}

.news__letter .button {
    padding: 10px 14px;
    border-radius: 22px;
    text-decoration: none;
    background: var(--color-hover);
    color: var(--color-black);
    background-size: 200%;
    transition: 0.5s ease-out;
    cursor: pointer;
    border: none;
    outline: none;
}


.news__letter h1,
.quick__link h1,
.support h1 {
    text-align: center;
    font-weight: 700;
    text-transform: capitalize;
    line-height: 1.5;
    text-transform: capitalize;
    color: var(--color-black);
    margin-bottom: 15px;
}

.quick__link {
    height: 10.5em;
    display: block;
}

.support {
    height: 10.5em;
    display: block;
}

.quick__link ul li,
.support ul li {
    list-style: none;
}

.quick__link ul li a,
.support ul li a {
    text-decoration: none;
    text-align: center;
    text-transform: capitalize;
    font-size: 16px;
    font-weight: unset;
    color: var(--color-black);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: start;
    margin-bottom: 10px;
}

.copyright {
    width: 100%;
    text-align: center;
    color: var(--color-black);
    font-size: 15px;
    font-weight: 500;
    padding: 2%;
}

/* Footer END */

@media (max-width:902) {

    .all__footer {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, auto));
        gap: 2em;
    }

}

@media (max-width:445px) {
  .all__footer {
        width: 100%;
        padding-top: 2%;
    }
}
    </style>
</head>
<body>
<section id="footer">

<div class="all__footer">
    <div class="news__letter">
        <h1>News Letter</h1>

        <input type="email" placeholder="Email Address">
        <button class="button" aria-pressed="false" aria-label="Send Message" target="_blank" rel="noopener">Send Message</button>
    </div>

    <div class="quick__link">

        <h1>Quick links</h1>
        <ul>
            <li>
                <a href="#">sign up</a>
                <a href="#">Join to team</a>
                <a href="#">blog</a>
            </li>
        </ul>
    </div>

    <div class="support">

        <h1>support</h1>
        <ul>
            <li>
                <a href="#">faqs</a>
                <a href="#">terms</a>
                <a href="#">privacy</a>
            </li>
        </ul>
    </div>
</div>
<div class="copyright">
    <p>© CopyRight 2024 Design by BELCADI EL MAHDI</p>
</div>
</section>
</body>
</html>