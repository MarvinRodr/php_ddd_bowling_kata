
## Bowling Game Kata

Credits: Inspired by Uncle Bob

### Bowling Rules
---

The game consists of 10 frames. In each frame the player has two rolls to knock down 10 pins. The score for the frame is the total number of pins knocked down, plus bonuses for strikes and spares.

A spare is when the player knocks down all 10 pins in two rolls. The bonus for that frame is the number of pins knocked down by the next roll.

A strike is when the player knocks down all 10 pins on his first roll. The frame is then completed with a single roll. The bonus for that frame is the value of the next two rolls.

In the tenth frame a player who rolls a spare or strike is allowed to roll the extra balls to complete the frame. However no more than three balls can be rolled in tenth frame.

### Requirements
---

Write a web (simply HTML) or cli application using Symfony to simulate the game.

The application may ask for the number of pins knocked down. And it may control automatic the frames, and after ech frame show the score

The application may save the points  on a database or a CSV file depending the configuration

The code may has test for the main features.

### Bonus points
---
Control more than one player

If is a web app use React or similar


## Your solution
---

### Must (These points are mandatory)

- Use Symfony or Laravel
- Be testable. This means that we should not need to run the main app in order to check that everything is working.
- Have a SOLUTION.md containing all the relevant features of your provided solution.

### Should (Nice to have)

- Fulfill the [Bonus point](#bonus-point) section of this readme.
- Be bug free.
- Use any design patterns you know and feel that help solve this problem.
- Be extensible to allow the introduction of new features in an easy way.
- Use any package dependency mechanism.
