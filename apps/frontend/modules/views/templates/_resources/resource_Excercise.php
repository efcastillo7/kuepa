<?php use_javascript("/assets/khan-exercises/khan-exercise.js") ?>
<div class="exercise">
    <div class="vars" data-ensure="A_START !== B_START">
        <var id="A_START">randRange( 1, 10 )</var>
        <var id="B_START">randRange( 1, 10 )</var>
        <var id="FACTOR">randRange( 1, 5 )</var>

        <var id="A">A_START * FACTOR</var>
        <var id="B">B_START * FACTOR</var>
        <var id="GCD">getGCD( A, B )</var>
        <var id="A_FACTORS">toSentence(getFactors( A ))</var>
        <var id="B_FACTORS">toSentence(getFactors( B ))</var>
    </div>

    <div class="problems">
        <div>
            <div class="question">
                <p>What is the greatest common divisor of <var>A</var> and <var>B</var>?</p>
                <p>Another way to say this is: </p>
                <p><code>\gcd(<var>A</var>, <var>B</var>) = {?}</code></p>
            </div>

            <p class="solution" data-forms="integer"><var>GCD</var></p>
        </div>
    </div>

    <div class="hints">
        <p>The greatest common divisor is the largest number that is a factor (or divisor) of both <var>A</var> and <var>B</var>.</p>
        <div>
            <p data-if="A === 1">The only factor (divisor) of 1 is 1.</p>
            <p data-else="">The factors (divisors) of <var>A</var> are <var>A_FACTORS</var>.</p>
        </div>
        <div>
            <p data-if="B === 1">The only factor (divisor) of 1 is 1.</p>
            <p data-else="">The factors (divisors) of <var>B</var> are <var>B_FACTORS</var>.</p>
        </div>
        <div>
            <p>Thus, the greatest common divisor of <var>A</var> and <var>B</var> is <var>GCD</var>.</p>
            <p><code>\gcd(<var>A</var>, <var>B</var>) = <var>GCD</var></code></p>
        </div>
    </div>
</div>
<div id="khan-containter"></div>