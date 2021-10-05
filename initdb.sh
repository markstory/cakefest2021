#!/bin/bash
cat cakefest2021.sql| docker exec -i cakefest2021_postgres psql my_app
