# TripTok - Travel Management App

## Overview

**TripTok** is a feature-rich travel management app designed to simplify and organize trip planning, budgeting, and itinerary management. Users can create detailed travel plans, manage accommodations and transportation, and keep track of trip expenses. The app also supports collaboration with friends and family, making it a perfect travel companion.

## Table of Contents

- [Features](#features)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Usage](#usage)
- [Technologies Used](#technologies-used)
- [Database Structure](#database-structure)
- [Contributing](#contributing)
- [License](#license)

---

## Features

- **User Authentication**: Secure sign-up, login, and logout functionality.
- **Trip Planning**: Users can create, edit, and delete trips with detailed itineraries and budget management.
- **Budget Tracking**: Automatically divides the trip budget across days and checks if users stay within budget limits.
- **Itinerary Management**: Add day-specific events, accommodations, and transport options with detailed timeframes.
- **Trip Sharing**: Share trip details with friends or family and divide the budget accordingly.
- **Notifications**: Users receive event reminders and trip updates.
- **Profile Customization**: Edit profile details, including profile picture upload.
- **Accessibility for All Travelers**: Special assistance options for elderly or pregnant travelers.
- **Weather Updates**: Get real-time weather information for trip destinations.
- **Queue Management and Priority Services**: Manage queue priorities at passport control, particularly for priority users.
- **Modular Design**: Pages and components are organized for easy maintenance and scalability.


---

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/lucifer-140/TripTok.git
    cd TripTok
    ```

2. **Database Setup**:
   - Ensure you have MySQL installed.
   - Import the database structure and sample data by running the SQL file in the `database/` folder.
   - Update the database connection details in `config/database.php`.

3. **Dependencies**:
   - Install required PHP dependencies by setting up a PHP server.
   - Ensure you have Laravel installed for full application setup.

---

## Usage

1. **Starting the Application**:
   - Open your localhost server, or navigate to the directory in your browser if using Laravel.
   - Navigate to the main page and register a new user or sign in.

2. **Creating a Trip**:
   - Go to **Plan Your Trip** and create a new trip by filling in the required details.
   - Add accommodations, flights, and events per day in the itinerary.

3. **Budget Tracking**:
   - Set a budget for the trip, and the app will automatically divide it per day, alerting if you exceed it.

4. **Trip Sharing**:
   - Share the trip itinerary with friends or family.

---

## Technologies Used

- **Frontend**: HTML, CSS, Bootstrap
- **Backend**: PHP, Laravel
- **Database**: MySQL
- **JavaScript**: Vanilla JS for interactivity
- **Server**: XAMPP for local development

---

## Database Structure

The database includes the following tables:

1. **User**: Stores user information.
2. **Trip**: Stores details of each trip.
3. **Flights**: Stores flight details for each trip.
4. **Accommodations**: Stores accommodation information.
5. **Transport**: Stores details of transportation options.
6. **Emergency Contacts**: Keeps emergency contacts for each trip.
7. **Currency Exchange**: Tracks currency exchange rates and budgets.
8. **To-Do**: Lists daily to-do items for trips.
9. **Notes**: Stores additional trip notes and goals.

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the project.
2. Create a new branch (`feature/my-new-feature`).
3. Commit your changes (`git commit -m 'Add my new feature'`).
4. Push to the branch (`git push origin feature/my-new-feature`).
5. Open a Pull Request.

---

## License

This project is licensed under the MIT License.

--- 
