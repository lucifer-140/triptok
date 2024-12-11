import csv
import random
from datetime import datetime, timedelta

# Function to generate realistic activity names
def generate_activity_name(country):
    activities = [
        f"Visit {country}'s famous landmarks",
        f"Try local cuisine in {country}",
        f"Explore the city center of {country}",
        f"Relax at a park in {country}",
        f"Go on a guided tour in {country}",
        f"Shopping at a local market in {country}",
        f"Take a scenic walk in {country}",
        f"Visit a museum in {country}",
        f"Attend a cultural event in {country}",
    ]
    return random.choice(activities)

# Function to generate realistic itinerary
def generate_trip_itinerary(countries):
    trips = []
    now = datetime.now()
    trip_id_counter = 1
    activity_id = 1

    for country in countries:
        # 2-3 trips per country
        num_trips = random.randint(2, 3)
        for _ in range(num_trips):
            trip_start_date = now + timedelta(days=random.randint(1, 30))
            trip_duration = random.randint(3, 7)  # 3-7 days
            trip_end_date = trip_start_date + timedelta(days=trip_duration - 1)
            total_budget = random.randint(1000, 5000)

            accommodation_name = f"Hotel {random.randint(1, 10)} in {country}"

            # Generate data for each day
            for day_offset in range(trip_duration):
                day_date = trip_start_date + timedelta(days=day_offset)
                day_start_time = datetime.combine(day_date, datetime.min.time()) + timedelta(hours=8)
                day_end_time = datetime.combine(day_date, datetime.min.time()) + timedelta(hours=20)
                current_time = day_start_time

                # Generate 3-4 activities with realistic times
                num_activities = random.randint(3, 4)
                for _ in range(num_activities):
                    activity_duration = random.randint(1, 2)  # 1-2 hours per activity
                    activity_start_time = current_time
                    activity_end_time = current_time + timedelta(hours=activity_duration)

                    if activity_end_time > day_end_time:
                        break  # Stop if we run out of time in the day

                    trip_data = {
                        "trip_id": trip_id_counter,
                        "country": country,
                        "trip_start_date": trip_start_date.strftime('%Y-%m-%d'),
                        "trip_end_date": trip_end_date.strftime('%Y-%m-%d'),
                        "day": day_offset + 1,
                        "date": day_date.strftime('%Y-%m-%d'),
                        "activity_id": activity_id,
                        "activity_title": generate_activity_name(country),
                        "activity_start_time": activity_start_time.strftime('%H:%M:%S'),
                        "activity_end_time": activity_end_time.strftime('%H:%M:%S'),
                        "activity_budget": random.randint(50, 200),
                        "activity_description": f"Enjoy a unique experience in {country}",
                        "transport_type": random.choice(["Taxi", "Bus", "Walk"]),
                        "transport_departure_time": activity_end_time.strftime('%H:%M:%S'),
                        "transport_arrival_time": (activity_end_time + timedelta(minutes=30)).strftime('%H:%M:%S'),
                        "transport_cost": random.randint(10, 50),
                        "accommodation_name": accommodation_name,
                        "accommodation_check_in": trip_start_date.strftime('%Y-%m-%d'),
                        "accommodation_check_out": trip_end_date.strftime('%Y-%m-%d'),
                        "accommodation_cost": total_budget // trip_duration,
                    }

                    trips.append(trip_data)
                    activity_id += 1
                    current_time = activity_end_time + timedelta(minutes=30)  # Add buffer time

            trip_id_counter += 1

    return trips

# Function to save data to CSV
def save_to_csv(data, filename):
    with open(filename, mode='w', newline='', encoding='utf-8') as file:
        writer = csv.DictWriter(file, fieldnames=data[0].keys())
        writer.writeheader()
        writer.writerows(data)

# List of countries
countries = [
    "France", "Japan", "Brazil", "Italy", "Australia",
    "Egypt", "Mexico", "South Africa", "United Kingdom", "Canada"
]

# Generate realistic trip itineraries
trip_data = generate_trip_itinerary(countries)

# Save to CSV
output_file = "realistic_trip_itineraries.csv"
save_to_csv(trip_data, output_file)
print(f"Realistic trip data successfully saved to {output_file}")
