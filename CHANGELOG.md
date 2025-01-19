# Changelog

All notable changes to `laravel-volition` will be documented in this file.

## Fix searching for actions via type - 2024-09-25

**Full Changelog**: https://github.com/square-bit/laravel-volition/compare/v2.0.1...v2.0.2

## Refactor storing of payloads - 2024-09-11

Payloads are now stored using their name and only properties defined in the constructor are stored.
A command was added 'volition:upgrade' to handle migrating the storing method.

Conditions and Actions must now be registered (in a service provider)
