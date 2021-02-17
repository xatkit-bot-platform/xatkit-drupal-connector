> ```
>  _____   _____ _    _       __  __ ______          _      _____  _               _   _ _   _ ______ _____  
> |  __ \ / ____| |  | |     |  \/  |  ____|   /\   | |    |  __ \| |        /\   | \ | | \ | |  ____|  __ \ 
> | |  | | (___ | |  | |     | \  / | |__     /  \  | |    | |__) | |       /  \  |  \| |  \| | |__  | |__) |
> | |  | |\___ \| |  | |     | |\/| |  __|   / /\ \ | |    |  ___/| |      / /\ \ | . ` | . ` |  __| |  _  / 
> | |__| |____) | |__| |     | |  | | |____ / ____ \| |____| |    | |____ / ____ \| |\  | |\  | |____| | \ \ 
> |_____/|_____/ \____/      |_|  |_|______/_/    \_\______|_|    |______/_/    \_\_| \_|_| \_|______|_|  \_\
>                                                                                                            
> ```                                                                                                            
                                                                                             
### 1 - ABOUT DSU MEALPLANNER

Provides integration of the Drupal Website to Smart Meal Planner from now on SMP, and a display page to view the resulting mealplanner.

This module extends de user profile fields to make the request to the SMP, and being able to store the user preferences in a Drupal-way.
    
### 2 - FEATURES

* Configurable user profile with user settings
* Route to display the user's mealplan 
* Recipes shown are imported on air
* OnBoarding avaliable wihtin the URL __projecturl/onboarding__
* Mealplan avaliable within the URL __projecturl/mealplanner__
* Shopping list feautre avaliable within the URL __projecturl/mealplanner/shopping


### 3 - INSTALLATION

1. PARAMETERS
    1. BASE URL: Base url of the mealplan endpoint
    2. SRH VERSION: Smart Recipe Hub version that we want to use
    3. COUNTRY LANGUAGE: Language that we want to use (Note: This language must be avaiable in the country)
    4. COUNTRY CODE: Country code that we want to use
    
2. INSTALLATION PROCESS

Simply enable de module with his dependencies, configure it with your settings and after that, configure the user profile.

Whenever you have everything set up, you should enable the form display of the fields. This is a Drupal 8 bug, normally you would not need to do this step. 

To do so, navigate to: Configuration -> People -> Account settings -> Manage form display, and enable all the disabled fields.

Then you can navigate to the url __projecturl/mealplanner__ to check your mealplan.



### 4 - UNINSTALL

To uninstall this module, simply delete all the extra user profile fields at Configuration -> People -> Account settings -> Manage fields
and after that, just uninstall the module.

### 5 - TODO
* Connect this module with the connect module

### 6 - DEVELOPERS

This module has declared the dsu_mealplanner.mealplanner service. 

	1 - Call method getMealPlan() if you have the configuration already set, to get the rendered compoenent of mealplan ( to embed it in a block or custom field)

	2 - Call method requestMealPlan() to have a mealplan in a array, ready to be rendered (if disired) in any component of the site. To call it, you need to pass the following parameters: (Check SMP documentation to get all the options )

		$nutritionMain: Array of string
	    $nutritionSecondaryList: Array of string,
	    $ingredientsList: Array of string
	    $mealRoutineList: Array of string
	    $mealPlanLenght: Array of timestamp dates
	    $cookingSkill: STRING
	    $servingsDefault: INTEGER
	    $isAnon: BOOLEAN (is anonymous or not)



### 7 - AUTHORS

__Daniel Rodriguez__ - Sopra Steria Barcelona

__Joan Giner__       - Sopra Steria Barcelona