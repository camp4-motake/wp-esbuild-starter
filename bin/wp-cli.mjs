#!usr/bin/env zx

/**
 * wp-cli shortcut
 */
import { $, argv } from 'zx';

const [command] = argv._;

await $`docker compose run --rm cli bash -c ${command}`;
