# Changelog

All notable changes to `laravel-volition` will be documented in this file.

## Filament v5 - 2026-02-09

### What's Changed

* Bump aglipanci/laravel-pint-action from 2.5 to 2.6 by @dependabot[bot] in https://github.com/square-bit/laravel-volition/pull/10

**Full Changelog**: https://github.com/square-bit/laravel-volition/compare/v12...v12.1

## Fix searching for actions via type - 2024-09-25

**Full Changelog**: https://github.com/square-bit/laravel-volition/compare/v2.0.1...v2.0.2

## Refactor storing of payloads - 2024-09-11

Payloads are now stored using their name and only properties defined in the constructor are stored.
A command was added 'volition:upgrade' to handle migrating the storing method.

Conditions and Actions must now be registered (in a service provider)
