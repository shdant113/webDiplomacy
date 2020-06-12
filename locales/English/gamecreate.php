<?php
/*
    Copyright (C) 2004-2010 Kestas J. Kuliukas

	This file is part of webDiplomacy.

    webDiplomacy is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    webDiplomacy is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with webDiplomacy.  If not, see <http://www.gnu.org/licenses/>.
 */

defined('IN_CODE') or die('This script can not be run by itself.');

/**
 * @package Base
 * @subpackage Forms
 */
?>

<!-- TO DO -->
<!-- add reset and back buttons -->
<!-- customize? -->
<!-- styles for things other than dark mode on desktop -->

<div class="content-bare content-board-header content-title-header">
	<div class="pageTitle barAlt1">Create a new Diplomacy game</div>
	<div class="pageDescription">Start a new game of Diplomacy. Use preset defaults or customize it yourself.</div>
</div>

<div class="content content-follow-on">
	<div class="game-create-outer-container">
		<h3 style="text-align: center;">Creating a game is easy. Just fill out the following questionnaire.</h3>
		<br>
		<hr>
		<?php
		// change this later or everything will be bad
		if (isset(Config::$customForumURL)) {
		?>
			<!-- BOTS OR HUMANS -->
			<!-- for bot games, link to botcreate.php or make a form here, which you also need to fix up -->
			<!-- this will actually load up one form or the other when this is done -->
			<div class="game-create-bothuman game-create-section">
				<h2 class="game-create-title">Play Bots or Humans?</h2>
				<p class="game-create-p">
					webDiplomacy is the first online Diplomacy site to feature gameplay against true artificial intelligence,
					trained on the decisions that real people made in countless situations over thousands of games. You can play
					against our artificial intelligence bots, or you can play a game against real people.
				</p>
				<div class="game-create-question">
					<strong>
						Do you want to play a game against bots or against humans?
					</strong>
				</div>
				<div class="game-create-buttons">
					<a href="botcreate.php"><input class="form-submit" value="Bots" /></a>
					<input class="form-submit" value="Humans" onClick="showNext('game-create-bothuman', 'game-create-private')" />
				</div>
			</div>
		<?php
		}
		?>

		<!-- BEGIN HUMAN FORM HERE -->
		<form class="human-form" method="post">

			<!-- PUBLIC OR PRIVATE GAME -->
			<div class="game-create-private game-create-section">
				<h2 class="game-create-title">Public or Private Game?</h2>
				<p class="game-create-p">
					If you are playing against family, friends, coworkers, or other people that you know from outside of webDiplomacy,
					we ask that you play a private game. Your game will be locked with a password so that people who you do not know
					do not accidentally join your game. That way, you can play without worrying about <a class="light" href="rules.php">metagaming</a>
					or violating any of our other <a class="light" href="rules.php">rules</a> on playing with people that you know. You can also use
					a private game to invite certain players that you want to play with if this is a tournament or special game that
					only certain people should join.
					<br><br>
					If this is a private game, you will be prompted to enter a password for the game at the end of this form.
					If none of that applies to you, you can create a public game and it will be open for anyone to join.
				</p>
				<div class="game-create-question">
					<strong>
						Do you want to play a private game or public game?
					</strong>
					<div class="game-create-buttons">
						<input class="form-submit" value="Private" onClick="setStorageKey('private'); showNext('game-create-private', 'game-create-name')" />
						<input class="form-submit" value="Public" onClick="showNext('game-create-private', 'game-create-name')" />
					</div>
				</div>
			</div>

			<!-- GAME NAME -->
			<div class="game-create-name game-create-section">
				<h2 class="game-create-title ">Game Title</h2>
				<p class="game-create-p">As the creator of a new game, you get to give it a title.</p>
				<div class="game-create-question">
					<strong>What do you want the title of your new game to be?</strong>
					<input class="gameCreate" type="text" name="newGame[name]" value="" size="30">
					<div class="game-create-buttons">
						<input class="form-submit" value="Submit" onClick="showNext('game-create-name', 'game-create-variant')" />
					</div>
				</div>
			</div>

			<!-- VARIANT CHOICES -->
			<div class="game-create-variant game-create-section">
				<h2 class="game-create-title">Map Choice</h2>
				<p class="game-create-p">
					webDiplomacy hosts a number of map choices to choose from. By default, the classic Diplomacy board,
					the same one used in the Avalon Hill board game, is selected for you, and if you are new to the game
					we recommend playing on it until you are more comfortable. The classic board requires 7 players and is
					a representation of pre-WWI Europe. We have a number of other variant maps that you can select and you can
					read about them all <a class="light" href="variants.php">here</a>, or check out one from the following list that you are
					curious about to read more:
					<br><br>
					<?php
					foreach (Config::$variants as $variantID => $variantName) {
						if ($variantID != 57) {
							$Variant = libVariant::loadFromVariantName($variantName);
							print $Variant->link() . '</br>';
						}
					}
					?>
					<br><br>
					Please note that if you choose either 1-on-1 map, your bet will be set to 5 points and the game will be unranked by default.
				</p>
				<div class="game-create-question">
					<strong>Which Diplomacy version do you want to play?</strong>
					<select id="variant" class="gameCreate" name="newGame[variantID]" onchange="setBotFill()">
						<?php
						$first = true;
						foreach (Config::$variants as $variantID => $variantName) {
							if ($variantID != 57) {
								$Variant = libVariant::loadFromVariantName($variantName);
								switch ($variantName) {
									case "Classic":
										print '<option name="newGame[variantID]" selected value="' . $variantID . '">Classic</option>';
										break;

									case "World":
										print '<option name="newGame[variantID]" value="' . $variantID . '">World Diplomacy IX</option>';
										break;

									case "AncMed":
										print '<option name="newGame[variantID]" value="' . $variantID . '">The Ancient Mediterranean</option>';
										break;

									case "ClassicFvA":
										print '<option name="newGame[variantID]" value="' . $variantID . '">Classic 1-on-1 - France vs Austria</option>';
										break;

									case "ClassicChaos":
										print '<option name="newGame[variantID]" value="' . $variantID . '">Classic - Chaos</option>';
										break;

									case "Modern2":
										print '<option name="newGame[variantID]" value="' . $variantID . '">Modern Diplomacy II</option>';
										break;

									case "Empire4":
										print '<option name="newGame[variantID]" value="' . $variantID . '">Fall of the American Empire IV</option>';
										break;

									case "ClassicGvI":
										print '<option name="newGame[variantID]" value="' . $variantID . '">Classic 1-on-1 - Germany vs Italy</option>';
										break;

									default:
										print '<option name="newGame[variantID]" value="' . $variantID . '">' . $variantName . '</option>';
										break;
								}
							}
						}
						?>
					</select>
					<div class="game-create-buttons">
						<input class="form-submit" value="Submit" onClick="check1v1()" />
					</div>
				</div>
			</div>

			<!-- SCORING -->
			<div class="game-create-scoring game-create-section">
				<h2 class="game-create-title">Scoring</h2>
				<p class="game-create-p">
					On webDiplomacy, games can be ranked or unranked. In a ranked game, you can lose your bet if your country is defeated,
					or if someone else wins the game, and your Ghost Rating will be affected. However, in an unranked game, your bet will
					be returned to you and your Ghost Rating will not be affected at all. In any ranked game, the winner will take the
					entire pot. However, not every ranked game ends with one player winning. Most games end in a draw and this setting
					will determine how points are split up if a game is eventually drawn.
					<br><br>
					In Draw-Size Scoring (DSS), the pot is split equally between the remaining players when the game draws.
					The winner takes all the points.
					<br><br>
					In Sum-of-Squares Scoring (SoS), the pot is divided based on how many supply centers you control when the game is drawn.
					<br><br>
					In an Unranked game, your bet will be returned to you whether you win or lose, and you will not win any points. Please
					note that in an Unranked game, your bet will always be the minimum bet of 5 points.
					<br><br>
					You can read about all of our scoring types in depth <a class="light" href="points.php#DSS">here</a>.
				</p>
				<div class="game-create-question">
					<strong>Which scoring type do you choose for your game?</strong>
					<select id="scoring" class="gameCreate" name="newGame[potType]">
						<?php
						$type = array("Winner-takes-all", "Sum-of-squares", "Unranked");
						foreach ($type as $t) {
							switch ($t) {
									// use local storage to store choice
								case "Winner-takes-all":
									print '<option name="newGame[potType]" value="Winner-takes-all" selected>Draw-Size Scoring</option>';
									break;

								case "Sum-of-squares":
									print '<option name="newGame[potType]" value="Sum-of-squares">Sum-of-Squares</option>';
									break;

								case "Unranked":
									print '<option name="newGame[potType]" value="Unranked">Unranked</option>';
									break;
							}
						}
						?>
					</select>
					<div class="game-create-buttons">
						<input class="form-submit" value="Submit" onClick="checkScoring()" />
					</div>
				</div>
			</div>

			<!-- GAME BET -->
			<!-- do not show if unranked -->
			<div class="game-create-bet game-create-section">
				<h2 class="game-create-title">Betting Points</h2>
				<p class="game-create-p">
					Diplomacy is a game of winning and losing. On webDiplomacy, each game has a pot. The winner of each game will
					take the pot as a prize for their conquest. The losers will lose the points that they put into the pot. You
					can bet up to <?php print $User->points; ?> points in this game, and anyone else that joins the game will have
					to match your bet in order to join. You cannot bet fewer than 5 points.
					<br><br>
					You can never have below 100 points, including those currently bet on games. If you have less than 100 points,
					you will be topped off to 100 again once some of your current games finish.
				</p>
				<div class="game-create-question">
					<strong>How many points do you want to bet (5-<?php print $User->points . libHTML::points(); ?>)?</strong>
					<input class="gameCreate" type="text" name="newGame[bet]" size="7" value="<?php print $formPoints ?>" />
					<div class="game-create-buttons">
						<input class="form-submit" value="Submit" onClick="showNext('game-create-bet', 'game-create-phase-info')" />
					</div>
				</div>
			</div>

			<!-- PHASE LENGTH -->
			<div class="game-create-phase-info game-create-section">
				<div class="game-create-phase-length">
					<h2 class="game-create-title">Phase Length</h2>
					<p class="game-create-p">
						The phase length determines how long each stage of the game will be. This will determine how long you spend
						playing your game. If you choose a longer phase length, or a non-live game, the game will probably last
						longer overall but require less consistent attention. For example, a game with a 7 day phase length may last
						for up to a year, but you may only need to check on the game a couple times per week in order to send messages
						and make sure your orders are submitted. On the other hand, a live game (game with a phase length of 30
						minutes or less) will require constant attention but will likely end within a few hours.
					</p>
					<div class="game-create-question">
						<strong>Do you want to play a live game or a non-live game?</strong>
						<div class="game-create-buttons">
							<input class="form-submit" value="Live" onClick="showNext('game-create-phase-length', 'game-create-live-open')" />
							<input class="form-submit" value="Non-Live" onClick="showNext('game-create-phase-length', 'game-create-live-closed')" />
						</div>
					</div>
				</div>

				<!-- if live game -->
				<div class="game-create-live-open game-create-section">
					<h2 class="game-create-title">Phase Length</h2>
					<div class="game-create-question">
						<strong>Live games move quickly. How long do you want each phase to last?</strong>
						<select class="gameCreate" name="newGame[phaseMinutes]" id="selectPhaseMinutesLive">
							<?php
							$phaseList = array(5, 7, 10, 15, 20, 30);
							foreach ($phaseList as $i) {
								print '<option value="' . $i . '"' . ($i == 5 ? ' selected' : '') . '>' . libTime::timeLengthText($i * 60) . '</option>';
							}
							?>
						</select>
						<div class="game-create-buttons">
							<input class="form-submit" value="Submit" onClick="showNext('game-create-live-open', 'game-create-phase-switch')" />
						</div>
					</div>
				</div>

				<div id="game-create-phase-switch" class="game-create-phase-switch game-create-section">
					<h2 class="game-create-title">Phase Length</h2>
					<p class="game-create-p">
						Do you or another player in your game need to leave after a certain period of time? In
						the event that you cannot finish your live game, you can set the phase length to change
						so that you have a longer amount of time to enter orders after a certain period of time.
						If you think this will be useful, select how long you want to play before the phase switches
						below. If you don't think you will need this, the default is set to "No phase switch"
						and you can simply go forward.
					</p>
					<div class="game-create-question">
						<strong>How long do you want to play before the phase length changes?</strong>
						<select class="gameCreate" id="selectPhaseSwitchPeriod" name="newGame[phaseSwitchPeriod]">
							<?php
							$phaseList = array(-1, 10, 15, 20, 30, 60, 90, 120, 150, 180, 210, 240, 270, 300, 330, 360);
							foreach ($phaseList as $i) {
								if ($i != -1) {
									print '<option value="' . $i . '"' . ($i == -1 ? ' selected' : '') . '>' . libTime::timeLengthText($i * 60) . '</option>';
								} else {
									print '<option value="' . $i . '"' . ($i == -1 ? ' selected' : '') . '> No phase switch</option>';
								}
							}
							?>
						</select>
						<div class="game-create-buttons">
							<input class="form-submit" value="Submit" onClick="checkPhaseSwitch()" />
						</div>
					</div>
				</div>
				<div id="game-create-next-phase" class="game-create-next-phase game-create-section">
					<h2 class="game-create-title">Phase Length</h2>
					<div class="game-create-question">
						<strong>How long should the phase length be when it changes?</strong>
						<select class="gameCreate" id="selectNextPhaseMinutes" name="newGame[nextPhaseMinutes]">
							<?php
							$phaseList = array(1440, 1440 + 60, 2160, 2880, 2880 + 60 * 2, 4320, 5760, 7200, 8640, 10080, 14400);
							foreach ($phaseList as $i) {
								print '<option value="' . $i . '"' . ($i == 1440 ? ' selected' : '') . '>' . libTime::timeLengthText($i * 60) . '</option>';
							}
							?>
						</select>
						<div class="game-create-buttons">
							<input class="form-submit" value="Submit" onClick="showNext('game-create-next-phase', 'game-create-time-fill')" />
						</div>
					</div>
				</div>

				<!-- if not live game -->
				<div class="game-create-live-closed game-create-section">
					<h2 class="game-create-title">Phase Length</h2>
					<div class="game-create-question">
						<strong>
							You can choose for your phase to last as long as 7 days or as little as 1 hour. How long do you want the phase to last?
						</strong>
						<select class="gameCreate" name="newGame[phaseMinutes]" id="selectPhaseMinutesNotLive">
							<?php
							$phaseList = array(
								60, 120, 240, 360, 480, 600, 720, 840, 960, 1080, 1200, 1320,
								1440, 1440 + 60, 2160, 2880, 2880 + 60 * 2, 4320, 5760, 7200, 8640, 10080, 14400
							);
							foreach ($phaseList as $i) {
								print '<option value="' . $i . '"' . ($i == 1440 ? ' selected' : '') . '>' . libTime::timeLengthText($i * 60) . '</option>';
							}
							?>
						</select>
						<div class="game-create-buttons">
							<input class="form-submit" value="Submit" onClick="showNext('game-create-live-closed', 'game-create-time-fill')" />
						</div>
					</div>
				</div>

				<!-- time to fill game -->
				<div class="game-create-time-fill game-create-section">
					<h2 class="game-create-title">Phase Length</h2>
					<p class="game-create-p">
						In order for the game to start, it has to be filled completely with players. You can choose how long you want to
						allow people to fill the game before the system cancels it if it does not fill with enough players. Please note
						that if your game is not live, it will start immediately when it is completely filled. However, a live game
						will take the full length you select even if it is completely filled before then.
					</p>
					<div class="game-create-question">
						<strong>How long can it take to fill your game before it is canceled?</strong></br>
						<select class="gameCreate" id="wait" name="newGame[joinPeriod]">
							<?php
							$phaseList = array(
								5, 7, 10, 15, 20, 30, 60, 120, 240, 360, 480, 600, 720, 840, 960, 1080, 1200, 1320,
								1440, 1440 + 60, 2160, 2880, 2880 + 60 * 2, 4320, 5760, 7200, 8640, 10080, 14400, 20160
							);
							foreach ($phaseList as $i) {
								print '<option value="' . $i . '"' . ($i == 10080 ? ' selected' : '') . '>' . libTime::timeLengthText($i * 60) . '</option>';
							}
							?>
						</select>
						<div class="game-create-buttons">
							<input class="form-submit" value="Submit" onClick="showNext('game-create-time-fill', 'game-create-messaging')" />
						</div>
					</div>
				</div>
			</div>

			<!-- PRESS -->
			<div class="game-create-messaging game-create-section">
				<h2 class="game-create-title">Press Style</h2>
				<p class="game-create-p">
					Diplomacy features different rules for messaging other players during the games, or press. You can choose to allow full press,
					meaning that anyone can speak publicly or privately to any player at any time; public press, meaning that anyone can
					speak publicly at any time but cannot speak privately to other players; rulebook press, meaning that there is no
					messaging allowed during build and retreat phases but full press during spring and autumn phases; or gunboat, meaning
					there is no messaging allowed at all.
					<br><br>
					Full press is considered default, so it is highlighted for you. Gunboat games are always anonymous.
				</p>
				<div class="game-create-question">
					<strong>
						Which press style would you like your game to be?
					</strong>
					<!-- when botfill goes live use this: -->
					<!-- <select class="gameCreate" id="pressType" name="newGame[pressType]" onchange="setBotFill()"> -->
					<select class="gameCreate" id="pressType" name="newGame[pressType]">
						<?php
						$pressTypes = array("Regular", "PublicPressOnly", "NoPress", "RulebookPress");
						foreach ($pressTypes as $type) {
							switch ($type) {
								case "Regular":
									print '<option name="newGame[pressType]" value="Regular" selected>Full Press</option>';
									break;

								case "PublicPressOnly":
									print '<option name="newGame[pressType]" value="PublicPressOnly">Public Press</option>';
									break;

								case "RulebookPress":
									print '<option name="newGame[pressType]" value="RulebookPress">Rulebook Press</option>';
									break;

								case "NoPress":
									print '<option name="newGame[pressType]" value="NoPress">Gunboat</option>';
									break;
							}
						}
						?>
					</select>
					<div class="game-create-buttons">
						<input class="form-submit" value="Submit" onClick="checkPressType()" />
					</div>
				</div>
			</div>

			<!-- BOT FILL -->
			<!-- bot stuff, not displayed yet. Usage will have to change with game creation wizard -->
			<!-- assuming this only works with classic? -->
			<div id="botFill" class="game-create-bot-fill game-create-section">
				<h2 class="game-create-title">Fill Open Spots With Bots</h2>
				<p class="game-create-p">
					If this option is selected, any empty spots in your game at the designated start time will fill with bots instead
					of being cancelled. This type of game will default to a 5 point bet, unranked scoring, and fully anonymous regardless
					of what settings you have chosen for the game. However, if your game fills completely with humans, your game will
					run with the settings that you choose just like any other.
				</p>
				<strong>Check the box to fill empty spots with bots:</strong>
				<input type="checkbox" id="botBox" class="gameCreate" name="newGame[botFill]" value="Yes">
				</br></br>
			</div>

			<!-- ANONYMITY -->
			<!-- if gunboat, do not show; default to anon -->
			<div class="game-create-anon game-create-section">
				<h2 class="game-create-title">Anonymity</h2>
				<p class="game-create-p">
					Some players prefer to play anonymous games, meaning that the names of other players in the game are not shown
					until after the game has concluded. A non-anonymous game allows everyone to see who is playing which country.
					By default, non-anonymous is highlighted for you.
				</p>
				<div class="game-create-question">
					<strong>Should players in your game be anonymous?</strong>
					<select class="gameCreate" name="newGame[anon]">
						<option name="newGame[anon]" value="No" selected>No</option>
						<option name="newGame[anon]" value="Yes">Yes</option>
					</select>
					<div class="game-create-buttons">
						<input class="form-submit" value="Submit" onClick="showNext('game-create-anon', 'game-create-draw-type')" />
					</div>
				</div>
			</div>

			<!-- DRAW TYPE -->
			<div class="game-create-draw-type game-create-section">
				<h2 class="game-create-title">Draw Votes</h2>
				<p class="game-create-p">
					Many players prefer to have their draw votes hidden so that other players do not know when they are or are not
					voting to draw a game. It is also traditional not to openly share who is or is not voting to draw in face-to-face
					Diplomacy. However, the highlighted default is to show all draw votes openly so that everyone knows when
					another player is or is not voting to draw.
				</p>
				<div class="game-create-question">
					<strong>Do you want to show or hide draw votes?</strong>
					<select class="gameCreate" name="newGame[drawType]">
						<option name="newGame[drawType]" value="draw-votes-public" selected>Show draw votes</option>
						<option name="newGame[drawType]" value="draw-votes-hidden">Hide draw votes</option>
					</select>
					<div class="game-create-buttons">
						<input class="form-submit" value="Submit" onClick="checkForSubmitIfPrivateGame()" />
					</div>
				</div>
			</div>

			<!-- RELIABILITY AND CIVIL DISORDERS -->
			<div class="game-create-rr-cds game-create-section">
				<h2 class="game-create-title">Reliability Rating and Civil Disorders</h2>
				<p class="game-create-p">
					Reliability is extremely important in Diplomacy because missing deadlines causes delays, which can break down
					relationships between players and cause fatigue. You can set a minimum reliability rating required to join your
					game. You can read more about reliability <a href="intro.php#RR">here</a>.
				</p>
				<div class="game-create-question">
					<strong>Required reliability rating:</strong></br>
					<input id="minRating" class="gameCreate" type="text" name="newGame[minimumReliabilityRating]" size="2" 
					value="<?php print $defaultRR ?>" onkeypress="if (event.keyCode==13) this.blur(); return event.keyCode!=13" 
					onChange="
							this.value = parseInt(this.value);
							if (this.value == 'NaN' ) this.value = 0;
							if (this.value < 0 ) this.value = 0;
							if (this.value > <?php print $maxRR ?> ) this.value = <?php print $User->reliabilityRating ?>;" 
					/>
				</div>
				<br><br>
				<p class="game-create-p">
					Civil disorder takes place when a country has been abandoned by its player. You can determine how many times
					a player can miss a deadline before they are removed from the game. If a player with delays remaining misses
					the deadline, the deadline will reset and the player will be charged 1 delay. If they are out of delays,
					their country will enter civil disorder. The game will only progress with missing orders if no replacement
					is found within one phase of that country entering civil disorder.
					<br><br>
					You can give players in your game up to 4 delays before they enter civil disorder. Set this value low to
					prevent delays in your game. Set it higher to be more forgiving to people that may need a delay every so often.
				</p>
				<div class="game-create-question">
					<select class="gameCreate" id="NMR" name="newGame[excusedMissedTurns]">
						<?php
						for ($i = 0; $i <= 4; $i++) {
							print '<option value="' . $i . '"' . ($i == 1 ? ' selected' : '') . '>' . $i . (($i == 0) ? ' (strict)' : '') . '</option>';
						}
						?>
					</select>

					<!-- will show button to create game if public game -->
					<div class="notice game-create-submit game-create-section">
						<input class="green-Submit" type="submit" value="Create">
					</div>

					<!-- will show button to move to invite code input if private game -->
					<div class="game-create-buttons game-create-section">
						<input class="form-submit" value="Submit" onClick="showNext('game-create-rr-cds', 'game-create-invite')" />
					</div>
				</div>
			</div>

			<!-- end of form for public games -->

			<!-- if private game -->
			<div class="game-create-invite game-create-section">
				<h2 class="game-create-title">Private Invite Code</h2>
				<p class="game-create-p">
					Send the invite code you choose here to your friends, family, or anyone else you would like to invite 
					to join your game. Without this code, they will not be able to join, so do not forget it!
				</p>
				<div class="game-create-question">
					<div>
						<img src="images/icons/lock.png" alt="Private" />
						<strong>Add Invite Code:</strong>
						</br>
						<input class="gameCreate" type="password" autocomplete="new-password" name="newGame[password]" value="" size="20" /></br>
						<br>
						<strong>Confirm:</strong>
						<input class="gameCreate" autocomplete="new-password" type="password" name="newGame[passwordcheck]" value="" size="20" /></br>
					</div>
					<div class="notice game-create-submit">
						<input class="green-Submit" type="submit" value="Create">
					</div>
				</div>
			</div>

			<!-- do some sort of review of settings? -->
		</form>
	</div>
</div>

<script src="locales/English/gamecreate.js?v=1"></script>