# Birthday Wishes Service

This PHP service component interacts with the Realm Digital Employee API to send birthday wishes to employees. It extracts a list of employees whose birthdays occur today and sends a generic birthday message to their email addresses.

## Requirements

- PHP 5.6 or higher
- Access to the Realm Digital Employee API (https://interview-assessment-1.realmdigital.co.za/)

## Installation

1. Clone the repository:

2. Configure the service:
- Open the `birthday_wishes.php` file and locate the `$email` variable.
- Replace `'your_email@example.com'` with the desired email address where birthday wishes should be sent.

## Usage

1. Open a terminal or command prompt and navigate to the cloned repository's directory.

2. Run the following command to execute the code:

3. The script will fetch the employees whose birthdays occur today, filter out any excluded employees, and send a birthday message to their email addresses.

## Additional Functionality

This service component can be extended to support additional messaging functionality, such as sending work anniversary messages. The code is structured in a way that allows for easy expansion and customization.

## Contributing

Contributions to this project are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).

