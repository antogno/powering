> [!NOTE]
> This project was created as a technical test on behalf of [Powering](https://poweringsrl.it).

# Powering

<p>
    <a href="https://github.com/antogno/powering/blob/master/LICENSE"><img src="https://img.shields.io/github/license/antogno/powering" alt="License"></a>
    <a href="https://github.com/antogno/powering/commits"><img src="https://img.shields.io/github/last-commit/antogno/powering" alt="Last commit"></a>
</p>

Simple management system in PHP for vehicles and branches of a company.

<p align="center">
    <img alt="Powering screenshot" src="https://raw.githubusercontent.com/antogno/powering/master/assets/images/screenshot.png" style="border-radius: 5px; box-shadow: rgba(0, 0, 0, 0.09) 0 3px 12px;">
</p>

---

## Table of contents

- [What is Powering?](#what-is-powering)
- [Usage](#usage)
- [License](#license)

## What is Powering?

Powering is a simple management system in PHP for vehicles and branches of a company. More specifically, Powering was created using the following tools and technologies:

- Back-end:
  - PHP 7.4 with [CodeIgniter 3.1.13](https://codeigniter.com/userguide3/general/welcome.html);
  - MySQL.
- Front-end:
  - HTML with [Smarty 4.2.1](https://smarty.net);
  - CSS with [Bootstrap 5.2.2](https://getbootstrap.com/docs/5.0/getting-started/introduction/);
  - JavaScript.

Powering also exists thanks to:

- [Font Awesome 6.2.0](https://fontawesome.com).

## Usage

### Setup

Copy the `.env.example` file in the root of the project, name it `.env` and change the values accordingly:

```console
$ cp .env.example .env
```

Build the containers:

```console
$ docker compose up --build -d
```

Install the Composer packages:

```console
$ composer install
```

Create the database tables:

```console
$ docker exec -it powering-mysql mysql -u powering -p
```

You'll be asked for the password, insert the one you put in your `.env` file, then:

```console
mysql> USE powering;
```

Copy and paste the following statements and press `Enter`:

```sql
CREATE TABLE `filiale` (
  `codice` int NOT NULL AUTO_INCREMENT,
  `indirizzo` varchar(50) NOT NULL,
  `citta` varchar(50) NOT NULL,
  `cap` varchar(5) NOT NULL,
  PRIMARY KEY (`codice`)
);
```

```sql
CREATE TABLE `automezzo` (
  `codice` int NOT NULL AUTO_INCREMENT,
  `codice_filiale` int NOT NULL,
  `targa` varchar(7) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modello` varchar(50) NOT NULL,
  PRIMARY KEY (`codice`),
  CONSTRAINT `fk_filialeautomezzo` FOREIGN KEY (`codice_filiale`)
  REFERENCES `filiale`(`codice`)
  ON UPDATE CASCADE
  ON DELETE CASCADE
);
```

Lastly, you can exit:

```console
mysql> exit
```

The app is now accessible at [localhost:8083](http://localhost:8083).

## License

Powering is licensed under the terms of the [Creative Commons Zero v1.0 Universal](https://github.com/antogno/powering/blob/master/LICENSE).

For more information, see the [Creative Commons website](https://creativecommons.org/publicdomain/zero/1.0/).

## Links

- [GitHub](https://github.com/antogno/powering)
- [LinkedIn](https://linkedin.com/in/antonio-granaldi/)
