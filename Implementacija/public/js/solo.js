/*
    Autor(i):
    Petar Tirnanic 19/0039
*/

$(document).ready(function() {

    //Tekst teksta koji se prekucava
    let text = $("input[name='_text']").val();
    //Pozicija zadnjeg slova koje je tacno prekucano
    let position = 0;
    //Pozicija zadnjeg slova koje je netacno prekucano, ako je jednako sa position, onda nema gresaka
    let mistakePosition = 0;

    //Da li je korisnik zapoceo kucanje
    let finished = false;
    //Da li je korisnik prekucao tekst
    let started = false;

    //Funkcija koja zapocinje merenje vremena
    function start() {
        if (started) return;
        started = true;
        setInterval(stopwatch, 10);
    }

    //Funkcija koja zavrsava sesiju kucanja i obradjuje rezultate AJAX pozivom
    function finish() {
        if (finished) return;
        finished = true;

        $("#userInput").remove();

        $.ajax({
            type: "POST",
            url: $("input[name='_endRoute']").val(),
            data: {
                "idTekst" : $("input[name='_idTekst']").val(),
                "time" : time,
                "_token" : $("input[name='_token']").val()
            }
        }).done(function(result) {
            $("#mainRow").html(result);
        });
    }

    //Funkcija koja meri vreme
    let time = 0.0;
    function stopwatch() {
        if (finished) return;
        time += 0.01;
        $("#time").text(time.toFixed(2) + " s")
    }

    //Funkcija koja oznacava da je naredno slovo ispravno prekucano
    function nextCorrect() {
        position++;
        mistakePosition++;

        if (position == text.length) {
            finish();
        }
    }

    //Funkcija koje inkrementira broj gresaka
    let mistakes = 0;
    function addMistake() {
        mistakes++;
        $("#mistakes").text(mistakes);
    }

    //Funkcija koja oznacava naredno slovo neispravno prekucano
    function nextMistake() {
        if (++mistakePosition > text.length) mistakePosition = text.length;
        if (mistakePosition == position + 1) addMistake();
    }

    //Funkcija koja boji tekst u zavisnosti od tacnosti prekucavanja
    function renderText() {
        let textParagraph = $("#textContent");

        let typed = $("<span><span/>").addClass("typedText");
        typed.text(text.substring(0, position));

        let bad = $("<span><span/>").addClass("mistakeText");
        bad.text(text.substring(position, mistakePosition));

        let notTyped = $("<span></span>").addClass("notTypedText");
        notTyped.text(text.substring(mistakePosition));

        textParagraph.empty();
        textParagraph.append(typed).append(bad).append(notTyped);
    }

    //Funkcija kojom se ponistava prekucavanje poslednje prekucanog slova
    function backspace() {
       if (--mistakePosition < 0) mistakePosition = 0;
        if (position > mistakePosition) position--;
    }

    //Funkcija koja obradjuje unos slova
    function letterTyped(letter) {
        if (position == mistakePosition && text.charAt(position) == letter) nextCorrect();
        else nextMistake();

        renderText();
    }

    //Hvatanje "backspace" unosa od korisnika
    $("#userInput").keydown(function( event ) {
        if (finished) return;
        if (event.which == 8) backspace();

        renderText();
    });

    //Hvatanje tekstualnih unosa od korisnika
    $("#userInput").keypress(function( event ) {
        start();
        event.preventDefault();
        if (finished) return;
        letterTyped(String.fromCharCode(event.which));
    });
    
});