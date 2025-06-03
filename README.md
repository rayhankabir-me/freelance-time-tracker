# Freelance Time Tracker API
"Freelance Time Tracker" allows freelancers to log and manage their work time across
clients and projects.


## Installation
1. Clone the project
```bash
    git clone git@github.com:rayhankabir-me/freelance-time-tracker.git
    cd freelance-time-tracker
```
2. Copy the .env.example file to .env
3. Put your database credentials
4. Run the commands below
```bash
  composer update
  php artisan migrate:fresh --seed
```



## API Reference

#### Register Users/Freelancers

```http
  POST /api/auth/register
```

| Form Data  | Type     | Description                |
|:-----------| :------- | :------------------------- |
| `name`     | `string` | **Required** |
| `email`    | `email` | **Required** |
| `password` | `string` | **Required** |

#### Login

```http
  POST /api/auth/login
```

| Form Body  | Type     | Description                       |
|:-----------|:---------| :-------------------------------- |
| `email`    | `email`  | **Required** |
| `password` | `string` | **Required** |


#### Logout

```http
  POST /api/auth/logout
```

| Authorization Header | Type     |
|:---------------------|:---------|
| `Bearer 'token'`     | `token`  |


#### Clients - Create - (Auth Required - Bearer Token )

```http
  POST api/clients
```

| Form Body  | Type     | Description  |
|:-----------|:---------|:-------------|
| `name`    | `string` | **Required** |
| `email` | `email`  | **Required** |
| `contact_person` | `string` | **Nullable** |

#### Clients - Lists Get - (Auth Required - Bearer Token )

```http
  GET api/clients
```

#### Clients - Show - (Auth Required - Bearer Token )

```http
  GET api/clients/show/{id}
```

#### Clients - Update - (Auth Required - Bearer Token )

```http
  POST/PUT/PATCH api/clients/{id}
```

| Form/JSON Body   | Type     | Description  |
|:-----------------|:---------|:-------------|
| `name`           | `string` | **Required** |
| `email`          | `email`  | **Required** |
| `contact_person` | `string` | **Nullable** |


#### Clients - Delete - (Auth Required - Bearer Token )

```http
  DELETE api/clients/{id}
```

#### Projects - Create - (Auth Required - Bearer Token )

```http
  POST /api/projects
```

| Form/JSON Body | Type             | Description  |
|:---------------|:-----------------|:-------------|
| `title`        | `string, unique` | **Required** |
| `status`       | `email`          | **Required** |
| `client_id`    | `integer`        | **Required** |
| `deadline`     | `date`           | **Nullable** |
| `description`         | `string`         | **Nullable** |

#### Projects - Get All - (Auth Required - Bearer Token )

```http
  GET /api/projects
```

#### Projects - Show - (Auth Required - Bearer Token )

```http
  GET /api/projects/show/1
```

#### Projects - Update - (Auth Required - Bearer Token )

```http
  POST/PUT/PATCH /api/projects/{id}
```

| Form/JSON Body | Type             | Description  |
|:---------------|:-----------------|:-------------|
| `title`        | `string, unique` | **Required** |
| `status`       | `email`          | **Required** |
| `client_id`    | `integer`        | **Required** |
| `deadline`     | `date`           | **Nullable** |
| `description`         | `string`         | **Nullable** |


#### Projects - DELETE - (Auth Required - Bearer Token )

```http
  DELETE /api/projects/{id}
```

#### TimeLogs - Get All - (Auth Required - Bearer Token )

```http
  GET /api/timelogs
```

#### TimeLogs - Manual Entry - (Auth Required - Bearer Token )

```http
  POST /api/timelogs/manual
```

| Form/JSON Body | Type      | Description  |
|:---------------|:----------|:-------------|
| `project_id`   | `integer` | **Required** |
| `start_time`       | `2024-06-01 09:00:00`        | **Required** |
| `end_time`    | `2024-06-01 11:30:00` | **Required** |
| `description`  | `string`  | **Nullable** |


#### TimeLogs - Start - (Auth Required - Bearer Token )

```http
  POST /api/timelogs/start
```

| Form/JSON Body | Type      | Description  |
|:---------------|:----------|:-------------|
| `project_id`   | `integer` | **Required** |
| `description`  | `string`  | **Nullable** |

#### TimeLogs - End - (Auth Required - Bearer Token )

```http
  POST /api/timelogs/end/{timelogs_id}
```

#### TimeLogs - Delete - (Auth Required - Bearer Token )

```http
  DELETE /api/timelogs/{id}
```
    
