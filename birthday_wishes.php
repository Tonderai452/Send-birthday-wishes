<?php

// Employee service class responsible for interacting with the API
class EmployeeService
{
    private $apiBaseUrl = "https://interview-assessment-1.realmdigital.co.za/";

    // Fetches a list of employees whose birthdays occur today
    public function getEmployeesWithBirthdayToday()
    {
        $url = $this->apiBaseUrl . "employees";
        $response = $this->sendRequest($url);

        if ($response && $response['status'] === 'success') {
            $employees = $response['data'];
            $employeesToday = [];

            // Filter employees whose birthdays are today
            foreach ($employees as $employee) {
                $birthDate = new DateTime($employee['birth_date']);
                $today = new DateTime();
                if ($birthDate->format('m-d') === $today->format('m-d')) {
                    $employeesToday[] = $employee;
                }
            }

            return $employeesToday;
        }

        return [];
    }

    // Sends a generic birthday message to the specified email address
    public function sendBirthdayWishes($email, $message)
    {
        // Send email implementation here
        // Example using PHP's built-in mail() function:
        mail($email, 'Birthday Wishes', $message);
    }

    // Sends an HTTP GET request to the specified URL and returns the response
    private function sendRequest($url)
    {
        // Use your preferred method to send the HTTP request (e.g., cURL, Guzzle, etc.)
        // Example using PHP's built-in file_get_contents():
        $response = @file_get_contents($url);

        if ($response) {
            return json_decode($response, true);
        }

        return null;
    }
}

// Birthday wishes service component
class BirthdayWishesService
{
    private $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    // Sends birthday wishes to employees
    public function sendBirthdayWishes()
    {
        $employeesToday = $this->employeeService->getEmployeesWithBirthdayToday();

        if (!empty($employeesToday)) {
            $employeeNames = array_column($employeesToday, 'name');
            $message = "Happy Birthday " . implode(", ", $employeeNames);
            $email = "your_email@example.com"; // Replace with your configured email address

            $this->employeeService->sendBirthdayWishes($email, $message);

            // Mark employees as already wished to prevent duplicate wishes on subsequent runs
            $this->markEmployeesAsWished($employeesToday);
        }
    }

    // Marks employees as already wished
    private function markEmployeesAsWished($employees)
    {
        // Implementation to mark employees as already wished (e.g., update a database flag)
    }
}

// Usage example
$employeeService = new EmployeeService();
$birthdayWishesService = new BirthdayWishesService($employeeService);
$birthdayWishesService->sendBirthdayWishes();

// Handling leap years and employee exclusions
class EmployeeService
{
    private $apiBaseUrl = "https://interview-assessment-1.realmdigital.co.za/";

    // Fetches a list of employees whose birthdays occur today
    public function getEmployeesWithBirthdayToday()
    {
        $url = $this->apiBaseUrl . "employees";
        $response = $this->sendRequest($url);

        if ($response && $response['status'] === 'success') {
            $employees = $response['data'];
            $employeesToday = [];

            // Filter employees whose birthdays are today, accounting for leap years
            $today = new DateTime();
            $currentYear = $today->format('Y');
            $isLeapYear = $this->isLeapYear($currentYear);

            foreach ($employees as $employee) {
                $birthDate = new DateTime($employee['birth_date']);
                $birthDateYear = $birthDate->format('Y');
                $isEmployeeBirthYearLeap = $this->isLeapYear($birthDateYear);

                if (
                    $birthDate->format('m-d') === $today->format('m-d') &&
                    ($isLeapYear && !$isEmployeeBirthYearLeap) // Handle February 29th in non-leap years
                ) {
                    $employeesToday[] = $employee;
                }
            }

            return $employeesToday;
        }

        return [];
    }

    // Checks if a given year is a leap year
    private function isLeapYear($year)
    {
        return ($year % 4 === 0 && $year % 100 !== 0) || ($year % 400 === 0);
    }

    // Sends a generic birthday message to the specified email address
    public function sendBirthdayWishes($email, $message)
    {
        // Send email implementation here
        // Example using PHP's built-in mail() function:
        mail($email, 'Birthday Wishes', $message);
    }

    // Sends an HTTP GET request to the specified URL and returns the response
    private function sendRequest($url)
    {
        // Use your preferred method to send the HTTP request (e.g., cURL, Guzzle, etc.)
        // Example using PHP's built-in file_get_contents():
        $response = @file_get_contents($url);

        if ($response) {
            return json_decode($response, true);
        }

        return null;
    }
}

// Birthday wishes service component
class BirthdayWishesService
{
    private $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    // Sends birthday wishes to employees
    public function sendBirthdayWishes()
    {
        $employeesToday = $this->employeeService->getEmployeesWithBirthdayToday();

        if (!empty($employeesToday)) {
            // Exclude employees who no longer work for Realm Digital or have opted out of birthday wishes
            $filteredEmployees = $this->filterExcludedEmployees($employeesToday);

            if (!empty($filteredEmployees)) {
                $employeeNames = array_column($filteredEmployees, 'name');
                $message = "Happy Birthday " . implode(", ", $employeeNames);
                $email = "your_email@example.com"; // Replace with your configured email address

                $this->employeeService->sendBirthdayWishes($email, $message);

                // Mark employees as already wished to prevent duplicate wishes on subsequent runs
                $this->markEmployeesAsWished($filteredEmployees);
            }
        }
    }
