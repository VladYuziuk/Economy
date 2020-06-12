-- #!mysql
-- #{ economy
-- #  { init
CREATE TABLE IF NOT EXISTS players(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(30) NOT NULL,
    money INT(11) NOT NULL
);
-- #  }
-- #  { add
-- #    { player
-- #      :username string
-- #      :money int
INSERT OR REPLACE INTO players(
    username,
    money
)VALUES(
    :username,
    :money
);
-- #    }
-- #  }
-- #  { get
-- #    { player
-- #      :username string
SELECT * FROM players WHERE username=:username;
-- #    }
-- #  }
-- #  { update
-- #    { money
-- #      :username string
-- #      :amount int
UPDATE players SET money=:amount WHERE username=:username;
-- #    }
-- #  }
-- #}