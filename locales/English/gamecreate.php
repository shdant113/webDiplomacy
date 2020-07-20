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

<!-- TO FIX -->
<!-- enter on component submit should not create game -->

<!-- TO DO -->
<!-- make all inputs div class game-create-button, tabindex them, onkeydown/onclick -->
<!-- style review page -->
<!-- customize instructions/text, improve accessibility by shortening instruction text and linking to other pages -->
<!-- make all links to other pages open a new tab so user does not lose their game if they click them -->

<div class="content-bare content-board-header content-title-header">
	<div class="pageTitle barAlt1">Create a new Diplomacy game</div>
	<div class="pageDescription">Start a new game of Diplomacy. Use preset defaults or customize it yourself.</div>
</div>

<div class="content content-follow-on game-create-container">
	<div class="game-create-back-reset-container">
		<div class="game-create-back-reset">
			<div class="back" onclick="goBack()" onkeydown="goBack()" tabindex="0">
				<h4>Back</h4>
			</div>
			<div class="reset" onclick="reset()" onkeydown="reset()" tabindex="0">
				<h4>Reset</h4>
			</div>
		</div>
		<hr>
	</div>
	<div class="game-create-outer-container">
		<?php
		if (isset(Config::$customForumURL)) {
		?>
			<!-- BOTS OR HUMANS -->
			<div class="game-create-bothuman game-create-section">
				<h2 class="game-create-title">Play Bots or Humans?</h2>
				<p class="game-create-p">
					webDiplomacy is the first online Diplomacy site to feature gameplay against true artificial intelligence,
					trained by the decisions that real people made in countless situations over thousands of games. You can play
					against our artificial intelligence bots, or you can play a game against real people.
				</p>
				<div class="game-create-question">
					<strong>
						Do you want to play a game against bots or against humans?
					</strong>
				</div>
				<div class="game-create-buttons">
					<div 
						tabindex="0" class="game-create-button form-submit"
						onclick="redirectToBots()"
						onkeydown="redirectToBots()"
					>Bots</div>
					<div 
						tabindex="0" class="game-create-button form-submit"
						onclick="showNext('game-create-bothuman', 'game-create-private')"
						onkeydown="showNext('game-create-bothuman', 'game-create-private')"
					>Humans</div>
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
					we ask that you play a private game. Your game will be protected with a password so that people who you do not know
					do not accidentally join your game. That way, you can play without worrying about violating any of our 
					<a class="light" href="rules.php">rules</a> on playing with people that you know. You can also use a private game to 
					invite certain players that you want to play with if this is a tournament or special game that only certain people should join.
					<br><br>
					If none of that applies to you, you can create a public game and it will be open for anyone to join.
					If the above does apply to you, you can create a private game. You will be prompted to enter a password for the game 
					at the end of this form.
				</p>
				<div class="game-create-question">
					<strong>
						Do you want to play a private game or public game?
					</strong>
					<div class="game-create-buttons">
						<div 
							tabindex="0" class="game-create-button form-submit"
							onclick="showNext('game-create-private', 'game-create-name', 'invite')" 
							onkeydown="showNext('game-create-private', 'game-create-name', 'invite')" 
						>Private</div>
						<div 
							tabindex="0" class="game-create-button form-submit" 
							onclick="showNext('game-create-private', 'game-create-name')"
							onkeydown="showNext('game-create-private', 'game-create-name')"
						>Public</div>
					</div>
				</div>
			</div>

			<!-- GAME NAME -->
			<div class="game-create-name game-create-section">
				<h2 class="game-create-title ">Game Title</h2>
				<p class="game-create-p">
					As the creator of a new game, you get to give it a title. The title of your game can be anything that 
					you like, but please keep it appropriate. 
				</p>
				<div class="game-create-question">
					<strong>What do you want the title of your new game to be?</strong>
					<div class="game-create-error" id="title-error">
						<div class="game-create-p">Your game must have a title.</div>
					</div>
					<input 
						class="game-create-margin gameCreate" id="title-box" type="text" name="newGame[name]" value="" size="30" 
						onkeydown="showNext('game-create-name', 'game-create-variant', 'title')" 
					/>
					<div class="game-create-buttons">
						<div 
							tabindex="0" class="game-create-button form-submit" 
							onclick="showNext('game-create-name', 'game-create-variant', 'title')"
							onkeydown="showNext('game-create-name', 'game-create-variant', 'title')"
						>Submit</div>
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
					a representation of pre-WWI Europe. We have a number of other variant maps that you can select. You can
					read about them all <a class="light" href="variants.php">here</a>, or check out one from the following list 
					that you are curious about to read more:
					<br><br>
					<?php
					foreach (Config::$variants as $variantID => $variantName) {
						if ($variantID != 57) {
							$Variant = libVariant::loadFromVariantName($variantName);
							print $Variant->link() . '</br>';
						}
					}
					?>
					<br>
					Please note that if you choose either 1-on-1 map, your bet will be set to 5 points and the game will be unranked by default.
				</p>
				<div class="game-create-question">
					<strong>Which Diplomacy map do you want to play?</strong>
					<select 
						id="variant" class="game-create-margin gameCreate" name="newGame[variantID]" onchange="setBotFill()" 
						onkeydown="showNext('game-create-variant', 'game-create-scoring', 'variant')"
					>
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
						<div 
							tabindex="0" class="game-create-button form-submit" 
							onclick="showNext('game-create-variant', 'game-create-scoring', 'variant')"
							onkeydown="showNext('game-create-variant', 'game-create-scoring', 'variant')" 
						>Submit</div>
					</div>
				</div>
			</div>

			<!-- SCORING -->
			<div class="game-create-scoring game-create-section">
				<h2 class="game-create-title">Scoring</h2>
				<p class="game-create-p">
					Games can be ranked or unranked. In a ranked game, you can lose your bet if your country is defeated,
					or if someone else wins the game, and your Ghost Rating will be affected, and you can win the entire pot if you win. 
					In an unranked game, your bet will be returned to you and your Ghost Rating will not be affected at all. 
					This setting allows you to choose an unranked game, or if you decide to choose a ranked game instead it will determine 
					how points are split in the event of a draw.
					<br><br>
					In Draw-Size Scoring (DSS), the pot is split equally between the remaining players when the game draws.
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
					<select 
						id="scoring" class="game-create-margin gameCreate" name="newGame[potType]" 
						onkeydown="showNext('game-create-scoring', 'game-create-bet', 'scoring')" 
					>
						<?php
						$type = array("Winner-takes-all", "Sum-of-squares", "Unranked");
						foreach ($type as $t) {
							switch ($t) {
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
						<div 
							tabindex="0" class="game-create-button form-submit"
							onclick="showNext('game-create-scoring', 'game-create-bet', 'scoring')" 
							onkeydown="showNext('game-create-scoring', 'game-create-bet', 'scoring')"
						>Submit</div>
					</div>
				</div>
			</div>

			<!-- GAME BET -->
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
					<div class="game-create-error" id="bet-error">
						<div class="game-create-p">Your game must have a valid bet (5-<?php print $User->points . libHTML::points(); ?>).</div>
					</div>
					<input class="game-create-margin gameCreate" id="bet" type="text" name="newGame[bet]" size="7" 
						value="<?php print $formPoints ?>" 
						onkeydown="showNext('game-create-bet', 'game-create-phase-length', 'points', <?php print $User->points?>)"
					/>
					<div class="game-create-buttons">
						<div 
							tabindex="0" class="game-create-button form-submit"
							onclick="showNext('game-create-bet', 'game-create-phase-length', 'points', <?php print $User->points?>)"
							onkeydown="showNext('game-create-bet', 'game-create-phase-length', 'points', <?php print $User->points?>)"
						>Submit</div>
					</div>
				</div>
			</div>

			<!-- PHASE LENGTH -->
			<div class="game-create-phase-info">
				<div class="game-create-phase-length game-create-section">
					<h2 class="game-create-title">Phase Length</h2>
					<p class="game-create-p">
						The phase length determines how long each stage of the game will be. If you choose a longer phase length, 
						or a non-live game, the game will probably last longer overall but require less consistent attention. 
						For example, a game with a 7 day phase length may last for up to a year, but you may only need to check on 
						the game a couple times per week in order to send messages and make sure your orders are submitted. 
						On the other hand, a live game (game with a phase length of 30 minutes or less) will require constant 
						attention but will likely end within a few hours.
					</p>
					<div class="game-create-question">
						<strong>Do you want to play a live game or a non-live game?</strong>
						<div class="game-create-buttons">
							<div 
								tabindex="0" class="game-create-button form-submit" 
								onclick="showNext('game-create-phase-length', 'game-create-live-open', 'live')"
								onkeydown="showNext('game-create-phase-length', 'game-create-live-open', 'live')"
							>Live</div>
							<div 
								tabindex="0" class="game-create-button form-submit" 
								onclick="showNext('game-create-phase-length', 'game-create-live-closed')"
								onkeydown="showNext('game-create-phase-length', 'game-create-live-closed')"
							>Non-Live</div>
						</div>
					</div>
				</div>

				<!-- if live game -->
				<div class="game-create-live-open game-create-section">
					<h2 class="game-create-title">Phase Length</h2>
					<div class="game-create-question">
						<strong>Live games move quickly. How long do you want each phase to last?</strong>
						<select 
							class="game-create-margin gameCreate" name="newGame[phaseMinutes]" id="selectPhaseMinutesLive" 
							onkeydown="showNext('game-create-live-open', 'game-create-phase-switch')"
						>
							<?php
							$phaseList = array(5, 7, 10, 15, 20, 30);
							foreach ($phaseList as $i) {
								print '<option value="' . $i . '"' . ($i == 5 ? ' selected' : '') . '>' . libTime::timeLengthText($i * 60) . '</option>';
							}
							?>
						</select>
						<div class="game-create-buttons">
							<div 
								tabindex="0" class="game-create-button form-submit" 
								onclick="showNext('game-create-live-open', 'game-create-phase-switch')" 
								onkeydown="showNext('game-create-live-open', 'game-create-phase-switch')"
							>Submit</div>
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
						<select class="game-create-margin gameCreate" id="selectPhaseSwitchPeriod" name="newGame[phaseSwitchPeriod]" onkeydown="checkEvent('livePhaseSwitchMinutes')">
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
							<div 
								tabindex="0" class="game-create-button form-submit" 
								onclick="showNext('game-create-phase-switch', 'game-create-time-fill', 'switch')"
								onkeydown="showNext('game-create-phase-switch', 'game-create-time-fill', 'switch')"
							>Submit</div>
						</div>
					</div>
				</div>
				<div id="game-create-next-phase" class="game-create-next-phase game-create-section">
					<h2 class="game-create-title">Phase Length</h2>
					<div class="game-create-question">
						<strong>How long should the phase length be when it changes?</strong>
						<select 
							class="game-create-margin gameCreate" id="selectNextPhaseMinutes" name="newGame[nextPhaseMinutes]" 
							onkeydown="showNext('game-create-next-phase', 'game-create-time-fill')"
						>
							<?php
							$phaseList = array(1440, 1440 + 60, 2160, 2880, 2880 + 60 * 2, 4320, 5760, 7200, 8640, 10080, 14400);
							foreach ($phaseList as $i) {
								print '<option value="' . $i . '"' . ($i == 1440 ? ' selected' : '') . '>' . libTime::timeLengthText($i * 60) . '</option>';
							}
							?>
						</select>
						<div class="game-create-buttons">
							<div 
								tabindex="0" class="game-create-button form-submit" 
								onclick="showNext('game-create-next-phase', 'game-create-time-fill')"
								onkeydown="showNext('game-create-next-phase', 'game-create-time-fill')" 
							>Submit</div>
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
						<select 
							class="game-create-margin gameCreate" name="newGame[phaseMinutes]" id="selectPhaseMinutesNotLive"
							onkeydown="showNext('game-create-live-closed', 'game-create-time-fill')"
						>
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
							<div
								tabindex="0" class="game-create-button form-submit" 
								onclick="showNext('game-create-live-closed', 'game-create-time-fill')"
								onkeydown="showNext('game-create-live-closed', 'game-create-time-fill')" 
							>Submit</div>
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
						<select 
							class="game-create-margin gameCreate" id="wait" name="newGame[joinPeriod]" 
							onkeydown="showNext('game-create-time-fill', 'game-create-messaging')"
						>
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
							<div 
								tabindex="0" class="game-create-button form-submit" 
								onclick="showNext('game-create-time-fill', 'game-create-messaging')" 
								onkeydown="showNext('game-create-time-fill', 'game-create-messaging')"
							>Submit</div>
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
					<select 
						class="game-create-margin gameCreate" id="pressType" name="newGame[pressType]" 
						onkeydown="showNext('game-create-messaging', 'game-create-anon', 'gunboat')" 
					>
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
						<div 
							tabindex="0" class="game-create-button form-submit" 
							onclick="showNext('game-create-messaging', 'game-create-anon', 'gunboat')" 
							onkeydown="showNext('game-create-messaging', 'game-create-anon', 'gunboat')" 
						>Submit</div>
					</div>
				</div>
			</div>

			<!-- BOT FILL -->
			<!-- bot stuff, not displayed yet. Usage will have to change with game creation wizard -->
			<!-- <div id="botFill" class="game-create-bot-fill game-create-section">
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
			</div> -->

			<!-- ANONYMITY -->
			<div class="game-create-anon game-create-section">
				<h2 class="game-create-title">Anonymity</h2>
				<p class="game-create-p">
					Some players prefer to play anonymous games, meaning that the names of other players in the game are not shown
					until after the game has concluded. A non-anonymous game allows everyone to see who is playing which country.
					By default, non-anonymous is highlighted for you.
				</p>
				<div class="game-create-question">
					<strong>Should players in your game be anonymous?</strong>
					<select 
						class="game-create-margin gameCreate" id="game-create-anon" name="newGame[anon]" 
						onkeydown="showNext('game-create-anon', 'game-create-draw-type')"
					>
						<option name="newGame[anon]" value="No" selected>No</option>
						<option name="newGame[anon]" value="Yes">Yes</option>
					</select>
					<div class="game-create-buttons">
						<div 
							tabindex="0" class="game-create-button form-submit" 
							onclick="showNext('game-create-anon', 'game-create-draw-type')" 
							onkeydown="showNext('game-create-anon', 'game-create-draw-type')"
						>Submit</div>
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
					<select 
						class="game-create-margin gameCreate" id="game-create-draw" name="newGame[drawType]" 
						onkeydown="showNext('game-create-draw-type', 'game-create-rr')"
					>
						<option name="newGame[drawType]" value="draw-votes-public" selected>Show draw votes</option>
						<option name="newGame[drawType]" value="draw-votes-hidden">Hide draw votes</option>
					</select>
					<div class="game-create-buttons">
						<div 
							tabindex="0" class="game-create-button form-submit"
							onclick="showNext('game-create-draw-type', 'game-create-rr')"
							onkeydown=onclick="showNext('game-create-draw-type', 'game-create-rr')" 
						>Submit</div>
					</div>
				</div>
			</div>

			<!-- RELIABILITY -->
			<div class="game-create-rr game-create-section">
				<h2 class="game-create-title">Reliability Rating</h2>
				<p class="game-create-p">
					Reliability is extremely important in Diplomacy because missing deadlines causes delays, which can break down
					relationships between players and cause fatigue. You can set a minimum reliability rating required to join your
					game. You can read more about reliability <a href="intro.php#RR">here</a>.
				</p>
				<div class="game-create-question">
					<strong>Required reliability rating (0-<?php print $User->reliabilityRating?>):</strong></br>
					<div class="game-create-error" id="rr-error">
						<div class="game-create-p">Your given reliability rating must fall between 0 and <?php print $User->reliabilityRating?>.</div>
					</div>
					<input 
						id="minRating" class="game-create-margin gameCreate" type="text" name="newGame[minimumReliabilityRating]" size="2" 
						value="<?php print $defaultRR ?>" 
						onkeydown="showNext('game-create-rr', 'game-create-cds', 'rr', <?php print $User->reliabilityRating?>)" 
					/>
					<div class="game-create-buttons">
						<div 
							tabindex="0" class="game-create-button form-submit" 
							onclick="showNext('game-create-rr', 'game-create-cds', 'rr', <?php print $User->reliabilityRating?>)" 
							onkeydown="showNext('game-create-rr', 'game-create-cds', 'rr', <?php print $User->reliabilityRating?>)"
						>Submit</div>
					</div>
				</div>
			</div>

			<!-- CIVIL DISORDERS -->
			<div class="game-create-cds game-create-section">
				<h2 class="game-create-title">Civil Disorders</h2>
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
					<select 
						class="gameCreate" id="NMR" name="newGame[excusedMissedTurns]" 
						onkeydown="showNext('game-create-cds', 'game-create-review', 'cds')" 
					>
						<?php
						for ($i = 0; $i <= 4; $i++) {
							print '<option value="' . $i . '"' . ($i == 1 ? ' selected' : '') . '>' . $i . (($i == 0) ? ' (strict)' : '') . '</option>';
						}
						?>
					</select>
					<br>
					<div class="game-create-buttons game-create-section" id="cd-public">
						<div 
							tabindex="0" class="game-create-button form-submit"
							onclick="showNext('game-create-cds', 'game-create-review', 'cds')" 
							onkeydown="showNext('game-create-cds', 'game-create-review', 'cds')" 
						>Submit</div>
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
					<div class="game-create-error" id="invite-error">
						<div class="game-create-p">You must enter a valid invite code.</div>
					</div>
					<div class="game-create-error" id="invite-error-match">
						<div class="game-create-p">Your invite codes do not match.</div>
					</div>
					<div class="game-create-margin">
						<img src="images/icons/lock.png" alt="Private" />
						<strong>Add Invite Code:</strong>
						</br>
						<input 
							class="game-create-margin gameCreate" type="password" autocomplete="new-password" 
							name="newGame[password]" value="" size="20" id="invite-input" 
						/></br>
						<br>
						<strong>Confirm:</strong>
						<input 
							class="game-create-margin gameCreate" autocomplete="new-password" type="password" 
							name="newGame[passwordcheck]" value="" size="20" id="invite-conf-input" 
							onkeydown="showNext('game-create-invite', 'game-create-review', 'code')"
						/></br>
					</div>
					<div class="game-create-buttons game-create-section">
						<div 
							tabindex="0" class="game-create-button form-submit" 
							onclick="showNext('game-create-invite', 'game-create-review', 'code')"
							onkeydown="showNext('game-create-invite', 'game-create-review', 'code')"
						>Submit</div>
					</div>
				</div>
			</div>

			<!-- settings review -->
			<div class="game-create-review game-create-section">
				<h2 class="game-create-title">Review</h2>
				<p class="game-create-p">
					Review the settings you have chosen for your game.
				</p>

				<div class="game-create-review-section">
					<span>
						<strong>Game name: </strong><span id="game-create-review-name"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review', 'game-create-name')" onkeydown="editForm('')">Edit</span>
				</div>
				
				<div class="game-create-review-section">
					<span>
						<strong>Map choice: </strong><span id="game-create-review-map"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review', 'game-create-variant')" onkeydown="checkEvent('')">Edit</span>
				</div>
				
				<div class="game-create-review-section">
					<span>
						<strong>Scoring type: </strong><span id="game-create-review-scoring"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review', 'game-create-scoring')" onkeydown="checkEvent('')">Edit</span>
				</div>
				
				<div class="game-create-review-section">
					<span>
						<strong>Bet: </strong><span id="game-create-review-bet"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review', 'game-create-bet')" onkeydown="checkEvent('')">Edit</span>
				</div>
				
				<div class="game-create-review-section">
					<span>
						<strong>Live or Non-Live? </strong><span id="game-create-review-live"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review', 'game-create-phase-length')" onkeydown="checkEvent('')">Edit</span>
				</div>
				
				<div class="game-create-review-section">
					<span>
						<strong>Phase Length: </strong><span id="game-create-review-phase-length"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review', 'game-create-phase-length')" onkeydown="checkEvent('')">Edit</span>
				</div>
				
				<!-- if live and phase length changes, show -->
				<div style="display: none;" id="game-create-review-live-switch">
					<div class="game-create-review-section">
						<span>
							<strong>Phase Switch: </strong><span id="game-create-review-phase-switch"></span>
						</span>
						<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review', 'game-create-phase-switch')" onkeydown="checkEvent('')">Edit</span>
					</div>

					<div class="game-create-review-section">
						<span>
							<strong>Phase Length After Switch: </strong><span id="game-create-review-phase-switch-length"></span>
						</span>
						<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review', 'game-create-next-phase')" onkeydown="checkEvent('')">Edit</span>
					</div>
				</div>

				<div class="game-create-review-section">
					<span>
						<strong>Time To Fill Game: </strong><span id="game-create-review-fill"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review')" onkeydown="checkEvent('')">Edit</span>
				</div>

				<div class="game-create-review-section">
					<span>
						<strong>Press Type: </strong><span id="game-create-review-press"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review')" onkeydown="checkEvent('')">Edit</span>
				</div>

				<div class="game-create-review-section">
					<span>
						<strong>Anonymous Players? </strong><span id="game-create-review-anon"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review')" onkeydown="checkEvent('')">Edit</span>
				</div>

				<div class="game-create-review-section">
					<span>
						<strong>Draw Votes Hidden? </strong><span id="game-create-review-draw"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review')" onkeydown="checkEvent('')">Edit</span>
				</div>

				<div class="game-create-review-section">
					<span>
						<strong>Reliability Rating Requirement: </strong><span id="game-create-review-rr"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review')" onkeydown="checkEvent('')">Edit</span>
				</div>

				<div class="game-create-review-section">
					<span>
						<strong>Excused Missed Turns Allowed: </strong><span id="game-create-review-cds"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review')" onkeydown="checkEvent('')">Edit</span>
				</div>

				<!-- if private, show -->
				<div style="display: none;" class="game-create-review-section" id="game-create-review-invite">
					<span>
						<strong>Invite Code: </strong>
						<span id="game-create-review-pw-button" tabIndex="0" onkeydown="checkEvent('code')" onClick="toggleShowCode()">[show invite code]</span>
						<span id="game-create-review-pw"></span>
					</span>
					<span class="game-create-review-edit" tabIndex="0" onClick="showNext('game-create-review')" onkeydown="checkEvent('')">Edit</span>
				</div>

				<div class="notice game-create-submit game-create-buttons">
					<input class="green-Submit" type="submit" value="Create Your Game">
				</div>
			</div>


		</form>
	</div>
</div>

<script src="locales/English/gamecreate.js?v=1"></script>
