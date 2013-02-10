// g++ -o switch switch.cpp
// RC Mains socket control program by Geoff Johnson.
// (c) 2012 Geoff Johnson.
// Based on the example GPIO in C program by Dom and Gert.

// Access from ARM Running Linux

#define BCM2708_PERI_BASE        0x20000000
#define GPIO_BASE                (BCM2708_PERI_BASE + 0x200000) /* GPIO controller */

#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <dirent.h>
#include <fcntl.h>
#include <assert.h>
#include <sys/mman.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <time.h>
#include <unistd.h>

#define PAGE_SIZE (4*1024)
#define BLOCK_SIZE (4*1024)

int  mem_fd;
unsigned char *gpio_mem, *gpio_map;
char *spi0_mem, *spi0_map;

// I/O access
volatile unsigned *gpio;

// GPIO setup macros. Always use INP_GPIO(x) before using OUT_GPIO(x) or SET_GPIO_ALT(x,y)
#define INP_GPIO(g) *(gpio+((g)/10)) &= ~(7<<(((g)%10)*3))
#define OUT_GPIO(g) *(gpio+((g)/10)) |=  (1<<(((g)%10)*3))
#define SET_GPIO_ALT(g,a) *(gpio+(((g)/10))) |= (((a)<=3?(a)+4:(a)==4?3:2)<<(((g)%10)*3))

#define GPIO_SET *(gpio+7)  // sets   bits which are 1 ignores bits which are 0
#define GPIO_CLR *(gpio+10) // clears bits which are 1 ignores bits which are 0

// function prototypes.
void setup_io();
void SendCode(char* szCode);

int main(int argc, char **argv)
{ 
	int g,rep;

	if (argc != 3)
	{
		printf("Lights app \n usage: switch sw[#] [on/off]\n");
	}
	else
	{
		// Set up gpi pointer for direct register access
		setup_io();

		// Switch GPIO 7 to output mode
		INP_GPIO(7); // must use INP_GPIO before we can use OUT_GPIO
		OUT_GPIO(7);

		char szOn[500] = {0};
		char szOff[500] = {0};

		if (strcmp (argv[1],"sw1") == 0)
		{
			strcpy(szOn, "000011101110111011101110111011101110100011101000111011101000111011101000100010001000111011101110111010000");
			strcpy(szOff,"000011101110111011101110111011101110100011101000111011101000111011101000100010001000100011101110111010000");
		}
		else if  (strcmp (argv[1],"sw2") == 0)
		{
			strcpy(szOn, "000011101110111011101110111011101110100011101000111011101000111011101000100010001000111010001110111010000");
			strcpy(szOff,"000011101110111011101110111011101110100011101000111011101000111011101000100010001000100010001110111010000");
		}
		else if  (strcmp (argv[1],"sw3") == 0)
		{
			strcpy(szOn, "000011101110111011101110111011101110100011101000111011101000111011101000100010001000111011101000111010000");
			strcpy(szOff,"000011101110111011101110111011101110100011101000111011101000111011101000100010001000100011101000111010000");
		}
		else if  (strcmp (argv[1],"sw4") == 0)
		{
			strcpy(szOn, "000011101110111011101110111011101110100011101000111011101000111011101000100010001000111011101110100010000");
			strcpy(szOff,"000011101110111011101110111011101110100011101000111011101000111011101000100010001000100011101110100010000");
		}
		else
		{
			printf("Invalid Channel, it should be 1 to 4.\n");
		}

		if (strlen(szOn))
		{
			if (strcmp(argv[2],"on") == 0)
			{
				SendCode(szOn);
			}
			else if (strcmp(argv[2],"off") == 0)
			{
				SendCode(szOff);
			}
			else
			{
				printf("Last argument should be on or off.\n");
			}
		}
	}
	return 0;
} // main

//
// Set up a memory regions to access GPIO
//
void setup_io()
{
	/* open /dev/mem */
	if ((mem_fd = open("/dev/mem", O_RDWR|O_SYNC) ) < 0) 
	{
		printf("Can't open /dev/mem \n");
		exit (-1);
	}

	/* mmap GPIO */
	// Allocate MAP block
	if ((gpio_mem = (unsigned char*)malloc(BLOCK_SIZE + (PAGE_SIZE-1))) == NULL) 
	{
		printf("Allocation error \n");
		exit (-1);
	}

	// Make sure pointer is on 4K boundary
	if ((unsigned long)gpio_mem % PAGE_SIZE)
	{
		gpio_mem += PAGE_SIZE - ((unsigned long)gpio_mem % PAGE_SIZE);
	}

	// Now map it
	gpio_map = (unsigned char *)mmap(
		(caddr_t)gpio_mem,
		BLOCK_SIZE,
		PROT_READ|PROT_WRITE,
		MAP_SHARED|MAP_FIXED,
		mem_fd,
		GPIO_BASE
		);

	if ((long)gpio_map < 0)
	{
		printf("mmap error %d\n", (int)gpio_map);
		exit (-1);
	}

	// Always use volatile pointer!
	gpio = (volatile unsigned *)gpio_map;
} // setup_io

// Function to send the output code to the RF transmitter connected to GPIO 7.
void SendCode(char* szCode)
{
	timespec sleeptime;
	timespec remtime;

	for (int iSend = 0 ; iSend < 10 ; iSend++)
	{
		sleeptime.tv_sec = 0;
		sleeptime.tv_nsec = 222000; // value obtained by trial and error to match transmitter

		for (int i = 0 ; i < strlen(szCode) ; i++)
		{
			if (szCode[i] == '1')
			{
				GPIO_SET = 1<<7;
			}
			else
			{
				GPIO_CLR = 1<<7;
			}
			nanosleep(&sleeptime,&remtime);
		}
		sleeptime.tv_nsec = 10000000; //10ms
		nanosleep(&sleeptime,&remtime);
	}
}
