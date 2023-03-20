# :bowling: BOWLING KATA POP SOLUTION! :bowling:

### Steps to run the project

1. ```make build```
2. Open your browser: [localhost](http://localhost:8040/).
3. Run tests: ```make test```
4. If necessary feel free to use the [Makefile](Makefile).
5. Feel free to try postman [collection](postman/API%20-%20Bowlling.postman_collection.json) and [environment](postman/bowlling_kaya_pop.postman_environment.json) 


:door: Controllers
---
```sh
src/Controller/
├── API
│   ├── HealthCheck
│   │   └── GetHealthCheckController.php
│   ├── Launch
│   │   └── PostLaunchController.php
│   └── Players
│       ├── GetPlayerScoreController.php
│       └── PostPlayerController.php
└── WEB
    └── Home
        └── GetHomeController.php
```

:railway_car: Modules
---
```sh
src/Modules/
├── Launches
│   ├── Application
│   │   ├── Calc
│   │   └── Create
│   ├── Domain
│   └── Infrastructure
│       └── Persistence
│           └── Doctrine
└── Players
    ├── Application
    │   ├── Create
    │   └── Score
    ├── Domain
    └── Infrastructure
        └── Persistence
            └── Doctrine
```

:hammer: Use Cases
---
### Players
```sh
src/Modules/Players/Application/
├── Create
│   └── PlayerCreator.php
├── PlayerResponse.php
├── PlayerScoreResponse.php
└── Score
    └── PlayerScoreFinder.php
```
### Launches
```sh
src/Modules/Launches/Application/
├── Calc
│   ├── SpareScoreCalculator.php
│   └── StrikeScoreCalculator.php
├── Create
│   └── LaunchCreator.php
└── LaunchResponse.php
```

Shared
---
```sh
src/Shared/
├── Domain
│   ├── Aggregate
│   │   └── AggregateRoot.php
│   ├── Assert.php
│   ├── Collection.php
│   ├── RandomNumberGenerator.php
│   ├── Response.php
│   ├── Utils.php
│   ├── UuidGenerator.php
│   └── ValueObject
│       ├── IntValueObject.php
│       ├── StringValueObject.php
│       └── Uuid.php
└── Infrastructure
├── Persistence
│   └── Doctrine
│       └── DoctrineRepository.php
├── PhpRandomNumberGenerator.php
└── RamseyUuidGenerator.php
```

Launches feature
---
```sh
src/Modules/Launches/Domain
├── Launch.php
├── LaunchFirstOne.php
├── LaunchNumFrame.php
├── LaunchRepository.php
├── LaunchSecondOne.php
├── LaunchThirdOne.php
└── Launches.php
```
As we can see we have the 2 possible launches in the Launch Model. 

This allows us to control the behaviour of each launch box. Defining the requirements of this within the domain of Launch.

```php
class Launch extends AggregateRoot
{
    private const MAX_NUM_PINS_CAN_BE_BOWLED = 10;
    private const MAX_NUM_OF_FRAMES = 10;

    public function __construct(
        private readonly UuidInterface $id,
        private readonly Player $player,
        private readonly LaunchFirstOne $first_one,
        private readonly LaunchSecondOne $second_one,
        private readonly LaunchThirdOne $third_one,
        private readonly LaunchNumFrame $num_frame
    ) {
        $this->ensureIsValidLaunch();
    }
}
```
### Score Calculation
As for the calculation of Strikes and Spares, they are calculated in the [launches](#launches) application layer.
They are divided into two different use cases, to improve scalability and single responsibility.

- [SpareScoreCalculator.php](src/Modules/Launches/Application/Calc/SpareScoreCalculator.php)
- [StrikeScoreCalculator.php](src/Modules/Launches/Application/Calc/StrikeScoreCalculator.php)
```sh
src/Modules/Launches/Application/Calc/
├── SpareScoreCalculator.php
└── StrikeScoreCalculator.php
```

Frontend Solution Using VUE
---
Components
```sh
assets/components/
├── BowlingLane.vue
└── Players
    └── CreatePlayerFormModal.vue
```

Pages
```sh
assets/pages/
└── home
    └── Home.vue
```









