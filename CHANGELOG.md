# Changelog

All notable changes to `laravel-volition` will be documented in this file.

## Refactor storing of payloads - 2024-09-11

Payloads are now stored using their name and only properties defined in the constructor are stored.
A command was added 'volition:upgrade' to handle migrating the storing method.

Conditions and Actions must now be registered (in a service provider)
