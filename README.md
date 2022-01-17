## About weatherpredict

This is an api that collects weather data from third party providers and uses this data to give weather predictions for given days. Key attributes are:

- [The api is deployed to a Digital Ocean droplet and is accessible on this url http://143.198.123.196/api/predict-weather/Amsterdam/temperature/celsius/20180112](http://143.198.123.196/api/predict-weather/Amsterdam/temperature/celsius/20180112).
- Collects data from temparature partners served in XML, JSON and CSV format

weatherpredict aggregates all the data from suppliers to give a weather prediction for a given day not more that 10 days from the current date. The api was created with the aim of being weather element agnostic i.e. with capability of being used to predict not only temperature but other weather elements like pressure and humidity

## Using the api

The api has crud operations for the resources it manages. To use the api one has to register as a user. After that a bearer token is issued which will give users access to protected crud functions:

Bearer token

<img width="1173" alt="Screenshot 2022-01-17 at 21 06 03" src="https://user-images.githubusercontent.com/16704814/149825348-95d1d172-88bd-460f-8520-e92e515ba960.png">


<img width="1169" alt="Screenshot 2022-01-17 at 13 46 44" src="https://user-images.githubusercontent.com/16704814/149824535-713d940b-f252-42d5-9cde-350c51a62859.png">

### Crud actions

- **Manage partners in the systmen**
- **Manage weather elements in the systmen**
- **Manage users elements in the systmen**

<img width="1157" alt="Screenshot 2022-01-17 at 14 04 20" src="https://user-images.githubusercontent.com/16704814/149824909-3432f227-eb38-4f55-a07e-fc8d97d7d1e7.png">

## Headers

Enusre the hear attributes Accept : application/json are added when making requests.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
