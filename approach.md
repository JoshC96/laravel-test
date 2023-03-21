### Note: I began to setup the project user docker desktop and DDEV before seeing the section in the Readme about Sail. Given time constraints, I'll progress without sail for now and document any issues I might have.


1. 

Generate models 
`php artisan make:model Lead -m` // -m will geneate a migration file alongside the model
`php artisan make:model Address  -m`

- Lead
    - First name
    - Last name
    - Email
    - Phone
    - Electric Bill
- Address
    - Street
    - City
    - State Abbreviation
    - Zip code

Key point: "Each Lead should have one Address established by a One-to-One relationship"


2. 

Run migrations 

Migrate `php artisan migrate`


3.

Seed the DB using faker
`php artisan make:seeder LeadSeeder` // We only need 1 seeder because it's a 1 to 1 relationship and we can seed addresses in the lead seeder.

Key point: "Each Lead should have one Address established by a One-to-One relationship"

Run seed queries
`php artisan db:seed --class=LeadSeeder`


4. 

- Create controllers inside an API directory in /app/controllers that extend `Controller.php`. Consider `#[Route('lead')]` syntax.  
    `php artisan make:request V1\LeadRequest`

     - Key point: "Your Controller should have minimal logic"
     - Key point: "You should use a Repository to interact with the database"
     - Key point: "API requests should be validated"
- Update the routes/api.php file with the new endpoints for GET, PUT, POST, DELETE. 
- Send back dummy data for now.
- Set the API version to 1.0

5. 

Create a validator for each endpoint's expected request params.


6. 

Update endpoints to include helpers to meet the following: 

**CREATE endpoint**:
    - This endpoint should accept the following data (parenthesis includes expected validation criteria):
    - First name            (required, max of 255 characters)
    - Last name             (required, max of 255 characters)
    - Email                 (required, RFC compliant email address)
    - Electric bill         (required, integer)
    - Street                (required, max of 255 characters)
    - City                  (required, max of 255 characters)
    - State Abbreviation    (required, exactly 2 characters)
    - Zip code              (required, exactly 5 characters)
- A Lead and a related Address should be created
- The Lead and related Address should be returned in a JSON response

**UPDATE endpoint:**
- This endpoint should accept the following data (parenthesis includes expected validation criteria):
    - Lead id (required, Lead id passed in should exist in the Leads table in the database)
    - Phone (required, numeric, exactly 10 characters)
- The Lead matching the passed in Lead ID should be updated to add / update the passed in Phone
- The Lead and related Address should be returned in a JSON response

**Delete endpoint:**
- This endpoint should accept a Lead ID
- The Lead and related Address matching the Lead ID should be *soft deleted*
    - All fields except IDs and Timestamps should be set to NULL
- A success response should be returned

**Read (single Lead) endpoint:**
- This endpoint should accept a Lead ID
- The Lead and related Address should be returned in a JSON response

**Read (multiple Leads) endpoint:**
- This endpoint should accept an *optional* `quality` query parameter
    - The acceptable values for `quality` can be `standard` or `premium`
        - The quality of a lead should be determined by whether or not the Electric Bill is above or below a configureable threshold. This value should default to 250, and should be able to be updated via your .env file
- If no `quality` parameter is submitted, all (non-soft-deleted) Leads and related Addresses should be returned in a JSON response
- If the `quality` parameter is equal to `premium`, all (non-soft-deleted) Leads and related Addresses equal to or above the configurable threshold should be returned
- If the `quality` parameter is equal to `standard`, all (non-soft-deleted) Leads and related Addresses below the configurable threshold should be returned