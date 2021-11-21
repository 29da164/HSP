#include	<stdio.h>
#include	<string.h>
#include	<unistd.h>
#include	<sys/ioctl.h>
#include	<arpa/inet.h>
#include	<sys/socket.h>
#include	<linux/if.h>
#include	<net/ethernet.h>
#include	<netpacket/packet.h>
#include	<netinet/if_ether.h>

int InitRawSocket(char *device){
	struct ifreq	ifreq;
	struct sockaddr_ll	sa;
	int	soc;

	soc = socket(PF_PACKET,SOCK_RAW,htons(ETH_P_ALL));
	memset(&ifreq,0,sizeof(struct ifreq));
	strncpy(ifreq.ifr_name,device,sizeof(ifreq.ifr_name)-1);
	ioctl(soc,SIOCGIFINDEX,&ifreq);
	sa.sll_family = PF_PACKET;
	sa.sll_protocol = htons(ETH_P_ALL);
	sa.sll_ifindex = ifreq.ifr_ifindex;
	bind(soc,(struct sockaddr *)&sa,sizeof(sa));
	ifreq.ifr_flags = ifreq.ifr_flags;
	ioctl(soc,SIOCSIFFLAGS,&ifreq);
	return(soc);
}

char *my_ether_ntoa_r(u_char *hwaddr,char *buf,socklen_t size){
	snprintf(buf,size,"%02x:%02x:%02x:%02x:%02x:%02x",
		hwaddr[0],hwaddr[1],hwaddr[2],hwaddr[3],hwaddr[4],hwaddr[5]);
	return(buf);
}

int PrintEtherHeader(struct ether_header *eh){
	char	buf[80];

	printf("To:   %s\n",my_ether_ntoa_r(eh->ether_dhost,buf,sizeof(buf)));
	printf("From: %s\n",my_ether_ntoa_r(eh->ether_shost,buf,sizeof(buf)));
	printf("Type: %02X",ntohs(eh->ether_type));
	switch(ntohs(eh->ether_type)){
		case 0x0800: printf("(IPv4)\n"); break;
		case 0x86dd: printf("(IPv6)\n"); break;
		case 0x0806: printf("(ARP)\n"); break;
		default: printf("(unknown)\n"); break;
	}
	return(0);
}

int main(int argc,char *argv[],char *envp[]){
	int	soc,size;
	u_char	buf[2048];

	soc = InitRawSocket(argv[1]);
	while(1){
		size = read(soc,buf,sizeof(buf));
		printf("Size: %d\n",size);
		PrintEtherHeader((struct ether_header *)buf);
	}

	return(0);
}
