$(document).ready(function() {

    let text = $("#textContent").text();
    let position = 0;
    let mistakePosition = 0;

    let finished = false;
    let started = false;

    function start() {
        if (started) return;
        started = true;
        setInterval(stopwatch, 10);
    }

    function finish() {
        if (finished) return;
        finished = true;
    }

    let time = 0.0;
    function stopwatch() {
        if (finished) return;
        time += 0.01;
        $("#time").text(time.toFixed(2) + " s")
    }

    function nextCorrect() {
        position++;
        mistakePosition++;

        if (position == text.length) {
            finish();
        }
    }

    let mistakes = 0;
    function addMistake() {
        mistakes++;
        $("#mistakes").text(mistakes);
    }

    function nextMistake() {
        if (++mistakePosition > text.length) mistakePosition = text.length;
        if (mistakePosition == position + 1) addMistake();
    }

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

    function backspace() {
       if (--mistakePosition < 0) mistakePosition = 0;
        if (position > mistakePosition) position--;
    }

    function letterTyped(letter) {
        if (position == mistakePosition && text.charAt(position) == letter) nextCorrect();
        else nextMistake();

        renderText();
    }

    $("#userInput").keydown(function( event ) {
        if (finished) return;
        if (event.which == 8) backspace();

        renderText();
    });

    $("#userInput").keypress(function( event ) {
        start();
        event.preventDefault();
        if (finished) return;
        letterTyped(String.fromCharCode(event.which));
    });
    
});